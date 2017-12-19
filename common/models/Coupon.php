<?php

namespace common\models;

use backend\components\Tool;
use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "coupon".
 *
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property string $description
 * @property integer $type
 * @property string $rule
 * @property string $expiration_date
 * @property integer $is_used
 * @property integer $order_id
 * @property integer $user_id
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $amount
 * @property integer $batch
 * @property integer $quantity
 */
class Coupon extends \yii\db\ActiveRecord
{
    const TYPE_CUT_PRICE = 1;//满减
    const TYPE_PERCENT = 2;//打折
    public $quantity;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon';
    }

    public $couponRule = [
        'minAmount',
        'minTotalAmount',
        'minQuantity',
        'percent',
        'cutPrice',
    ];
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['quantity', 'title','amount'], 'required','on'=>'batch'],
            [['type', 'is_used', 'order_id', 'user_id', 'created_by', 'created_at','quantity'], 'integer'],
            [['rule'], 'string'],
            [['expiration_date'], 'safe'],
            [['batch'], 'string', 'max' => 24],
            [['code'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 64],
            [['description'], 'string', 'max' => 255],
            [['amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'code' => Yii::t('common', 'Code'),
            'title' => Yii::t('common', 'Title'),
            'description' => Yii::t('common', 'Description'),
            'type' => Yii::t('common', 'Type'),
            'rule' => Yii::t('common', 'Rule'),
            'expiration_date' => Yii::t('common', 'Expiration Date'),
            'is_used' => Yii::t('common', 'Is Used'),
            'order_id' => Yii::t('common', 'Order ID'),
            'user_id' => Yii::t('common', 'User ID'),
            'created_by' => Yii::t('common', 'Created By'),
            'created_at' => Yii::t('common', 'Created At'),
            'amount' => Yii::t('common', 'Amount'),
            'batch' => Yii::t('common', 'Batch'),
            'quantity' => Yii::t('common', 'Quantity'),
        ];
    }

    public function getValidCoupon(){
        if($this->is_used){
            throw new Exception("此优惠券已被使用");
        }
        if($this->expiration_date && $this->expiration_date < date('Y-m-d')){
            throw new Exception("此优惠券已过期");
        }

    }
    public function getValidOrder($total_price=0,$total_quantity=1){
        if($this->rule){
            $rule = \GuzzleHttp\json_decode($this->rule);
            if (isset($rule->minTotalAmount) && $rule->minTotalAmount > $total_price ) {
                throw new Exception("订单金额不满足使用条件");
            }
            if (isset($rule->minQuantity) && $rule->minQuantity > $total_quantity) {
                throw new Exception("订单商品数量不满足使用条件");
            }
        }
    }

    public static function makeBatch(){
        return date('YmdH').Tool::random(4);
    }

    public static function makeCode($batch){
        $prefix = strtoupper(substr(md5($batch),0,2));
        return $prefix.Tool::random(6,'0123456789ABCDEFGHIJKLMNPQRSTUVWXYZ');
    }

    public static function types($type=null){
        $ary = [
            static::TYPE_CUT_PRICE => '满减',
            static::TYPE_PERCENT=>'打折'
        ];
        return $type !== null ? (isset($ary[$type]) ? $ary[$type] : null) : $ary;
    }
}
