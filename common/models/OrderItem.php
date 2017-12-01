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
 * @property string $package_item_title
 * @property string $price
 * @property string $sale_price
 * @property integer $quantity
 * @property string $use_date
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
            [['order_id', 'package_id', 'package_item_id', 'package_item_title', 'price', 'quantity', 'use_date'], 'required'],
            [['order_id', 'package_id', 'package_item_id', 'quantity'], 'integer'],
            [['price', 'sale_price'], 'number'],
            [['use_date'], 'safe'],
            [['package_item_title'], 'string', 'max' => 255],
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
            'package_item_title' => Yii::t('common', 'Package Item Title'),
            'price' => Yii::t('common', 'Price'),
            'sale_price' => Yii::t('common', 'Sale Price'),
            'quantity' => Yii::t('common', 'Quantity'),
            'use_date' => Yii::t('common', 'Use Date'),
        ];
    }
    
}
