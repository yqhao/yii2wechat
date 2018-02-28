<?php

namespace common\models;

use common\models\query\OrderQuery;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $code
 * @property string $package_title
 * @property integer $user_id
 * @property integer $package_id
 * @property integer $total_quantity
 * @property string $total_price
 * @property string $total_sale_price
 * @property string $payment_price
 * @property string $discount
 * @property string $discount_info
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $payment_type
 * @property integer $payment_status
 * @property string $coupon_code
 * @property string $contact_id_number
 * @property string $contact_name
 * @property string $contact_mobile
 * @property string $remark
 * @property integer $after_sale_status
 * @property integer $refund_status
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_CANCEL = 0;//已取消
    const STATUS_CREATED = 1;//新订单

    const REFUND_STATUS_DEFAULT = 0;//未申请
    const REFUND_STATUS_APPLIED = 1;//已申请退款
    const REFUND_STATUS_SUCCESS = 2;//退款成功
    const REFUND_STATUS_FAIL = 3;//退款失败

    const PAYMENT_TYPE_DEFAULT = 0;//默认
    const PAYMENT_TYPE_WX = 1;//微信支付

    const PAYMENT_STATUS_NO = 0; //未支付
    const PAYMENT_STATUS_YES = 1; //已支付

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }
//    public function scenarios()
//    {
//        return [
//            'create' => [
//                'code',
//                'user_id',
//                'package_id',
//                'total_quantity',
//                'total_price',
//                'discount',
//                'discount_info',
//                'created_at',
//                'coupon_code',
//            ]
//        ];
//    }

//    public function transactions()
//    {
//        return [
//            'add' => self::OP_INSERT
//        ];
//    }
    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [[ 'package_id', 'total_quantity', 'coupon_code', 'contact_name', 'remark'], 'required','on' => 'add'],
            [['code', 'package_title', 'user_id', 'package_id', 'total_quantity', 'total_price', 'created_at'], 'required'],
            [['user_id', 'package_id', 'total_quantity', 'created_at', 'updated_at', 'status', 'payment_type', 'payment_status', 'after_sale_status','refund_status'], 'integer'],
            [['total_price','total_sale_price', 'payment_price', 'discount'], 'number'],
            [['discount_info','remark','package_title'], 'string'],
            [['code', 'coupon_code','contact_id_number'], 'string', 'max' => 32],
            [['package_title', 'remark'], 'string', 'max' => 255],
            [['contact_name'], 'string', 'max' => 64],
            [['contact_mobile'], 'string', 'max' => 24],
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
            'package_title' => Yii::t('common', 'Package Title'),
            'user_id' => Yii::t('common', 'User ID'),
            'package_id' => Yii::t('common', 'Package ID'),
            'total_quantity' => Yii::t('common', 'Total Quantity'),
            'total_price' => Yii::t('common', 'Total Price'),
            'total_sale_price' => Yii::t('common', 'Total Sale Price'),
            'payment_price' => Yii::t('common', 'Payment Price'),
            'discount' => Yii::t('common', 'Discount'),
            'discount_info' => Yii::t('common', 'Discount Info'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'status' => Yii::t('common', 'Status'),
            'payment_type' => Yii::t('common', 'Payment Type'),
            'payment_status' => Yii::t('common', 'Payment Status'),
            'coupon_code' => Yii::t('common', 'Coupon Code'),
            'contact_id_number' => Yii::t('common', 'Contact Id Number'),
            'contact_name' => Yii::t('common', 'Contact Name'),
            'contact_mobile' => Yii::t('common', 'Contact Mobile'),
            'remark' => Yii::t('common', 'Remark'),
            'after_sale_status' => Yii::t('common', 'After Sale Status'),
            'refund_status' => Yii::t('common', 'Refund Status'),
        ];
    }
    /**
     * @return OrderQuery
     */
    public static function find()
    {
        return new OrderQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(Coupon::className(), ['id' => 'order_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['package_id' => 'id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'id']);
    }
    public function getUserWechat()
    {
        return $this->hasOne(UserWechat::className(), ['user_id' => 'user_id']);
    }
    public static function makeCode(){

        return date('ymdHi').str_pad(mt_rand(0,9999),4,'0',STR_PAD_LEFT);
    }
    public static function status($key=null){
        $ary = [
            static::STATUS_CANCEL => '已取消',
            static::STATUS_CREATED=>'已下单'
        ];
        return $key !== null ? (isset($ary[$key]) ? $ary[$key] : null) : $ary;
    }
    public static function paymentStatus($key=null){
        $ary = [
            static::PAYMENT_STATUS_NO => '未付款',
            static::PAYMENT_STATUS_YES=>'已付款'
        ];
        return $key !== null ? (isset($ary[$key]) ? $ary[$key] : null) : $ary;
    }
    public static function paymentTypes($key=null){
        $ary = [
            static::PAYMENT_TYPE_DEFAULT => '默认',
            static::PAYMENT_TYPE_WX=>'微信支付'
        ];
        return $key !== null ? (isset($ary[$key]) ? $ary[$key] : null) : $ary;
    }

    public static function refundStatus($key=null){
        $ary = [
            static::REFUND_STATUS_DEFAULT => '未申请',
            static::REFUND_STATUS_APPLIED => '已申请',
            static::REFUND_STATUS_SUCCESS => '退款成功',
            static::REFUND_STATUS_FAIL => '退款失败',
        ];
        return $key !== null ? (isset($ary[$key]) ? $ary[$key] : null) : $ary;
    }
    public static function getRefundStatusForPage($key){
        $span = '';
        $label = static::refundStatus($key);
        switch ($key){
            case static::REFUND_STATUS_DEFAULT:
                $span = '<span class="label label-primary">'.$label.'</span>';
                break;
            case static::REFUND_STATUS_APPLIED:
                $span = '<span class="label label-warning">'.$label.'</span>';
                break;
            case static::REFUND_STATUS_SUCCESS:
                $span = '<span class="label label-success">'.$label.'</span>';
                break;
            case static::REFUND_STATUS_FAIL:
                $span = '<span class="label label-danger">'.$label.'</span>';
                break;
            default: break;
        }
        return $span;
    }
    public static function getPaymentStatusForPage($key){
        //success warning primary danger
        $span = '';
        $label = static::paymentStatus($key);
        switch ($key){
            case static::PAYMENT_STATUS_NO:
                $span = '<span class="label label-primary">'.$label.'</span>';
                break;
            case static::PAYMENT_STATUS_YES:
                $span = '<span class="label label-success">'.$label.'</span>';
                break;
            default: break;
        }
        return $span;
    }
    public static function getPaymentTypeForPage($key){
        //success warning primary danger
        $span = '';
        $label = static::paymentTypes($key);
        switch ($key){
            case static::PAYMENT_TYPE_DEFAULT:
                $span = '<span class="label label-primary">'.$label.'</span>';
                break;
            case static::PAYMENT_TYPE_WX:
                $span = '<span class="label label-success">'.$label.'</span>';
                break;
            default: break;
        }
        return $span;
    }

}
