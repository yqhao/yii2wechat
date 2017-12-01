<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wx_package_item".
 *
 * @property integer $id
 * @property integer $package_id
 * @property string $title
 * @property string $cover
 * @property string $price
 * @property string $market_price
 * @property string $price_rise_at_weekend
 * @property string $price_rise_at_holiday
 * @property string $weekend_price
 * @property string $holiday_price
 * @property integer $sales
 * @property integer $stock
 * @property integer $weight
 * @property string $max_can_use_integral
 * @property string $integral
 * @property integer $is_published
 * @property integer $create_at
 * @property integer $update_at
 * @property integer $last_update
 * @property string $content
 * @property string $detail
 * @property string $special_description
 * @property string $unsubscribe_rules
 * @property string $change_rules
 * @property string $important_clause
 * @property string $description
 * @property string $booking_advance
 * @property string $base_url
 *
 * @property WxPackage $package
 */
class WxPackageItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wx_package_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_id', 'sales', 'stock', 'weight', 'is_published', 'create_at', 'update_at', 'last_update'], 'integer'],
            [['title'], 'required'],
            [['price', 'market_price', 'weekend_price', 'holiday_price', 'max_can_use_integral', 'integral'], 'number'],
            [['content', 'detail', 'special_description', 'unsubscribe_rules', 'change_rules', 'important_clause'], 'string'],
            [['title', 'cover', 'description', 'base_url'], 'string', 'max' => 255],
            [['price_rise_at_weekend', 'price_rise_at_holiday'], 'string', 'max' => 16],
            [['booking_advance'], 'string', 'max' => 8],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => WxPackage::className(), 'targetAttribute' => ['package_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'package_id' => Yii::t('common', 'Package ID'),
            'title' => Yii::t('common', 'Title'),
            'cover' => Yii::t('common', 'Cover'),
            'price' => Yii::t('common', 'Price'),
            'market_price' => Yii::t('common', 'Market Price'),
            'price_rise_at_weekend' => Yii::t('common', 'Price Rise At Weekend'),
            'price_rise_at_holiday' => Yii::t('common', 'Price Rise At Holiday'),
            'weekend_price' => Yii::t('common', 'Weekend Price'),
            'holiday_price' => Yii::t('common', 'Holiday Price'),
            'sales' => Yii::t('common', 'Sales'),
            'stock' => Yii::t('common', 'Stock'),
            'weight' => Yii::t('common', 'Weight'),
            'max_can_use_integral' => Yii::t('common', 'Max Can Use Integral'),
            'integral' => Yii::t('common', 'Integral'),
            'is_published' => Yii::t('common', 'Is Published'),
            'create_at' => Yii::t('common', 'Create At'),
            'update_at' => Yii::t('common', 'Update At'),
            'last_update' => Yii::t('common', 'Last Update'),
            'content' => Yii::t('common', 'Content'),
            'detail' => Yii::t('common', 'Detail'),
            'special_description' => Yii::t('common', 'Special Description'),
            'unsubscribe_rules' => Yii::t('common', 'Unsubscribe Rules'),
            'change_rules' => Yii::t('common', 'Change Rules'),
            'important_clause' => Yii::t('common', 'Important Clause'),
            'description' => Yii::t('common', 'Description'),
            'booking_advance' => Yii::t('common', 'Booking Advance'),
            'base_url' => Yii::t('common', 'Base Url'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(WxPackage::className(), ['id' => 'package_id']);
    }
}
