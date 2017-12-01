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
 * @property string $contact_name
 * @property string $contact_mobile
 * @property string $remark
 * @property integer $after_sale_status
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_CREATED = 0;
    const PAYMENT_STATUS_NO = 0;
    const PAYMENT_STATUS_YES = 1;

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
            [['user_id', 'package_id', 'total_quantity', 'created_at', 'updated_at', 'status', 'payment_type', 'payment_status', 'after_sale_status'], 'integer'],
            [['total_price','total_sale_price', 'payment_price', 'discount'], 'number'],
            [['discount_info','remark','package_title'], 'string'],
            [['code', 'coupon_code'], 'string', 'max' => 32],
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
            'contact_name' => Yii::t('common', 'Contact Name'),
            'contact_mobile' => Yii::t('common', 'Contact Mobile'),
            'remark' => Yii::t('common', 'Remark'),
            'after_sale_status' => Yii::t('common', 'After Sale Status'),
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

    public static function makeCode(){

        return date('ymdHi').str_pad(mt_rand(0,9999),4,'0',STR_PAD_LEFT);
    }

//    public function addOrder($data){
//
//
//        $insertOrder = [
//            'code' => self::makeCode(),
//            'user_id' => $data['user_id'],
//            'package_id' => $data['package_id'],
//            'total_quantity' => $data['total_quantity'],
//            'total_price' => $data['total_price'],
//            'discount' => $data['discount'],
//            'discount_info' => $data['discount_info'],
//            'created_at' => time(),
//            'status' => 0,
//            'coupon_code' => $data['coupon_code'],
//        ];
//        $insertOrderItem = [
//            'order_id' => $data['order_id'],
//            'package_id' => $data['package_id'],
//            'package_item_id' => $data['package_item_id'],
//            'price' => $data['price'],
//            'sale_price' => $data['sale_price'],
//            'amount' => $data['amount']
//        ];
//        $transaction = Yii::$app->db->beginTransaction();
//        try {
//            $transaction->createCommand($sql,$insertOrder)->execute();
//            $transaction->getLastInsertID();
//            $transaction->createCommand($sql2)->execute();
//            // ... executing other SQL statements ...
//            $transaction->commit();
//        } catch (Exception $e) {
//            $transaction->rollBack();
//        }
//    }
}
