<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $package_id
 * @property integer $package_item_id
 * @property string $price
 * @property string $sale_price
 * @property integer $quantity
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'package_id', 'package_item_id', 'price', 'quantity'], 'required'],
            [['order_id', 'package_id', 'package_item_id', 'quantity'], 'integer'],
            [['price', 'sale_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'order_id' => Yii::t('common', 'Order ID'),
            'package_id' => Yii::t('common', 'Package ID'),
            'package_item_id' => Yii::t('common', 'Package Item ID'),
            'price' => Yii::t('common', 'Price'),
            'sale_price' => Yii::t('common', 'Sale Price'),
            'quantity' => Yii::t('common', 'Quantity'),
        ];
    }
    
}
