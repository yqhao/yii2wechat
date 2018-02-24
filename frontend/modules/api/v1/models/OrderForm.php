<?php
namespace frontend\modules\api\v1\models;

use cheatsheet\Time;
use common\models\Coupon;
use common\models\Order;
use common\models\OrderItem;
use common\models\Package;
use common\models\PackageItem;
use common\models\User;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\web\ForbiddenHttpException;

/**
 * Login form
 */
class OrderForm extends Model
{
    public $order_id;
    public $order_code;
    public $package_id;
    public $package_item_id;
    public $use_date;
    public $total_quantity = 1;
    public $coupon_code;
    public $contact_id_number;
    public $contact_name;
    public $contact_mobile;
    public $remark;
    public $total_pay_amount;

    private $model;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'package_id', 'total_quantity', 'package_item_id','contact_name','contact_mobile','use_date'], 'required', 'on' => 'create'],
            [[ 'coupon_code','order_code','use_date','contact_id_number'], 'string', 'max' => 32],
            [[ 'contact_name'], 'string', 'max' => 64],
//            [[ 'contact_mobile'], 'string', 'max' => 16],
            [[ 'remark'], 'string', 'max' => 255],
            [[ 'order_id'], 'integer', 'max' => 255],
            ['contact_mobile','\common\validators\MobileValidator','on'=>'create','message'=>'手机号码格式有误，请重新输入'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('common', 'Order ID'),
            'order_code' => Yii::t('common', 'Order Code'),
            'package_id' => Yii::t('common', 'Package ID'),
            'package_item_id' => Yii::t('common', 'Package ID'),
            'total_quantity' => Yii::t('common', 'Total Quantity'),
            'use_date' => Yii::t('common', 'Use Date'),
            'coupon_code' => Yii::t('common', 'Coupon Code'),
            'contact_id_number' => Yii::t('common', 'Contact ID Number'),
            'contact_name' => Yii::t('common', 'Contact Name'),
            'contact_mobile' => Yii::t('common', 'Contact Mobile'),
            'remark' => Yii::t('common', 'Remark'),
        ];
    }


    /**
     * @return Order
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = new Order();
        }
        return $this->model;
    }


    public function save()
    {
        if ($this->validate()) {
            $model = $this->getModel();
            $orderItem = new OrderItem();

            if($this->getScenario() == 'create'){
                $package = Package::findOne(['id'=>$this->package_id,'is_published'=>Package::STATUS_PUBLISHED]);
                if(empty($package)){
                    throw new Exception('数据不存在');
                }
                $total_quantity = (int)$this->total_quantity;
                if($package->stock < $total_quantity){
                    throw new Exception('库存不足,下单失败');
                }
                $package->stock -= $total_quantity;
                $package->sales += $total_quantity;
                if(!$package->save()){
                    throw new Exception('下单失败.');
                }

                $packageItem = PackageItem::findOne(['id'=>$this->package_item_id,'is_published'=>Package::STATUS_PUBLISHED]);
                if(empty($packageItem)){
                    throw new Exception('数据不存在');
                }
                if($packageItem->stock < $total_quantity){
                    throw new Exception('库存不足,下单失败');
                }
                $packageItem->stock -= $total_quantity;
                $packageItem->sales += $total_quantity;
                if(!$packageItem->save()){
                    throw new Exception('下单失败..');
                }

                $model->package_id = $package->id;
                
                $model->code = Order::makeCode();
                $model->package_title = $package->title;
                $model->user_id = \Yii::$app->user->identity->getUserId();
                $model->total_quantity = $total_quantity;
                $model->total_price = ($total_quantity * $packageItem->getRealPrice(strtotime($this->use_date)));
                $model->created_at = time();
                $model->status = Order::STATUS_CREATED;
                
                $model->contact_id_number = $this->contact_id_number;
                $model->contact_name = $this->contact_name;
                $model->contact_mobile = $this->contact_mobile;
                $model->remark = $this->remark;
                $model->payment_price = $model->total_price;
                $coupon = null;

                if($this->coupon_code && $couponCode = trim($this->coupon_code)){
                    $coupon = Coupon::findOne(['code'=>$couponCode]);
                    if(empty($coupon)){
                        throw new Exception('优惠券不存在');
                    }
                    $coupon->getValidCoupon();
                    $coupon->getValidOrder($model->total_price,$model->total_quantity);

                    $model->discount_info = $coupon->rule;
                    $model->coupon_code = $coupon->code;
                    switch ($coupon->type) {
                        case Coupon::TYPE_CUT_PRICE:
                            $payAmount = ($model->total_price - $coupon->amount);
                            $model->payment_price = $payAmount > 0 ?  $payAmount : 0;
                            $model->discount = $coupon->amount;
                            break;
                        case Coupon::TYPE_PERCENT:
                            $payAmount = ($model->total_price * (1 - $coupon->amount));
                            $model->payment_price = $payAmount > 0 ?  $payAmount : 0;
                            $model->discount = ($model->total_price *  $coupon->amount);
                            break;
                        default: break;
                    }
                    $coupon->is_used = 1;
                    $coupon->user_id = $model->user_id;

                }

                if(!$model->save()){
                    throw new Exception('下单失败');
                }
                if(!empty($coupon)){
                    $coupon->order_id = $model->id;
                    $coupon->save();
                }

                $orderItem->order_id = $model->id;
                $orderItem->package_id = $model->package_id;
                $orderItem->package_item_id = $packageItem->id;
                $orderItem->package_item_title = $packageItem->title;
                $orderItem->price = $packageItem->price;
                $orderItem->quantity = $model->total_quantity;
                $orderItem->use_date = $this->use_date;
                if(!$orderItem->save()){
//                    print_r($orderItem->getErrors());exit;
                    throw new Exception("下单失败!".implode(',',$orderItem->getErrors()));
                }
                $this->order_id = $model->id;
                $this->order_code = $model->code;
                $this->total_pay_amount = $model->payment_price;

            }

            return !$model->hasErrors() && !$orderItem->hasErrors();
        }
        return null;
    }
}
