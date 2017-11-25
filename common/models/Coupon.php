<?php

namespace common\models;

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
 */
class Coupon extends \yii\db\ActiveRecord
{
    const TYPE_CUT_PRICE = 0;
    const TYPE_PERCENT = 1;
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
            [['code', 'title'], 'required'],
            [['type', 'is_used', 'order_id', 'user_id', 'created_by', 'created_at'], 'integer'],
            [['rule'], 'string'],
            [['expiration_date'], 'safe'],
            [['code'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 64],
            [['description'], 'string', 'max' => 255],
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
        ];
    }

    public function getValidCoupon($order = null){
        if($this->is_used){
            throw new Exception("此优惠券已被使用");
        }
        if($this->expiration_date < date('Y-m-d')){
            throw new Exception("此优惠券已过期");
        }

    }
}
