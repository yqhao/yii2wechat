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
    public $total_quantity = 1;
    public $coupon_code;
    public $contact_name;
    public $contact_mobile;
    public $remark;

    private $model;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'package_id', 'total_quantity', 'package_item_id','contact_name','contact_mobile'], 'required', 'on' => 'create'],
            [[ 'coupon_code','order_code'], 'string', 'max' => 32],
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
            'coupon_code' => Yii::t('common', 'Coupon Code'),
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
                $packageItem = PackageItem::findOne(['id'=>$this->package_item_id,'is_published'=>Package::STATUS_PUBLISHED]);
                if(empty($packageItem)){
                    throw new Exception('数据不存在');
                }


                $model->package_id = $package->id;
                
                $model->code = Order::makeCode();
                $model->package_title = $package->title;
                $model->user_id = 1;
                $model->total_quantity = $this->total_quantity;
                $model->total_price = ($this->total_quantity * $packageItem->price);
                $model->created_at = time();
                $model->status = 0;
                
                $model->contact_name = $this->contact_name;
                $model->contact_mobile = $this->contact_mobile;
                $model->remark = $this->remark;
                $model->payment_price = $model->total_price;

                if($this->coupon_code && $couponCode = trim($this->coupon_code)){
                    $coupon = Coupon::findOne(['code'=>$couponCode]);
                    if(empty($coupon)){
                        throw new Exception('优惠券不存在');
                    }
                    $coupon->getValidCoupon();

                    if ($coupon->rule['minTotalAmount'] > $model->total_price ) {
                        throw new Exception("订单金额不满足使用条件");
                    }
                    if ($coupon->rule['minQuantity'] > $model->total_quantity) {
                        throw new Exception("订单商品数量不满足使用条件");
                    }

                    $model->discount_info = $coupon->rule;
                    $model->coupon_code = $coupon->code;
                    switch ($coupon->type) {
                        case Coupon::TYPE_CUT_PRICE:
                            $model->payment_price = ($model->total_price - $coupon->rule['cutPrice']);
                            $model->discount = $coupon->rule['cutPrice'];
                            break;
                        case Coupon::TYPE_PERCENT:
                            $model->payment_price = ($model->total_price * (1 - $coupon->rule['percent']));
                            $model->discount = ($model->total_price *  $coupon->rule['percent']);
                            break;
                        default: break;
                    }
                }

                if(!$model->save()){
                    throw new Exception('下单失败');
                }

                $orderItem->order_id = $model->id;
                $orderItem->package_id = $model->package_id;
                $orderItem->package_item_id = $packageItem->id;
                $orderItem->package_item_title = $packageItem->title;
                $orderItem->price = $packageItem->price;
                $orderItem->quantity = $model->total_quantity;
                if(!$orderItem->save()){
//                    print_r($orderItem->getErrors());exit;
                    throw new Exception("下单失败!");
                }
                $this->order_id = $model->id;
                $this->order_code = $model->code;
            }

            return !$model->hasErrors() && !$orderItem->hasErrors();
        }
        return null;
    }
}
