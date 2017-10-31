<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wx_package".
 *
 * @property integer $id
 * @property string $app_id
 * @property integer $category_id
 * @property string $title
 * @property string $cover
 * @property string $price
 * @property string $sale_price
 * @property integer $sales
 * @property integer $is_recommend
 * @property integer $stock
 * @property integer $weight
 * @property integer $goods_type
 * @property string $max_can_use_integral
 * @property string $integral
 * @property integer $express_rule_id
 * @property integer $is_seckill
 * @property integer $seckill_status
 * @property integer $is_group_buy
 * @property integer $is_published
 * @property integer $create_at
 * @property integer $update_at
 * @property integer $last_update
 * @property string $description
 * @property string $content
 * @property string $detail
 * @property string $images
 * @property string $address
 *
 * @property WxPackageItem[] $wxPackageItems
 */
class Package extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wx_package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'sales', 'is_recommend', 'stock', 'weight', 'goods_type', 'express_rule_id', 'is_seckill', 'seckill_status', 'is_group_buy', 'is_published', 'create_at', 'update_at', 'last_update'], 'integer'],
            [['price', 'sale_price', 'max_can_use_integral', 'integral'], 'number'],
            [['content', 'detail', 'images'], 'string'],
            [['app_id'], 'string', 'max' => 64],
            [['title', 'cover', 'description', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'app_id' => Yii::t('common', 'App ID'),
            'category_id' => Yii::t('common', 'Category ID'),
            'title' => Yii::t('common', 'Title'),
            'cover' => Yii::t('common', 'Cover'),
            'price' => Yii::t('common', 'Price'),
            'sale_price' => Yii::t('common', 'Sale Price'),
            'sales' => Yii::t('common', 'Sales'),
            'is_recommend' => Yii::t('common', 'Is Recommend'),
            'stock' => Yii::t('common', 'Stock'),
            'weight' => Yii::t('common', 'Weight'),
            'goods_type' => Yii::t('common', 'Goods Type'),
            'max_can_use_integral' => Yii::t('common', 'Max Can Use Integral'),
            'integral' => Yii::t('common', 'Integral'),
            'express_rule_id' => Yii::t('common', 'Express Rule ID'),
            'is_seckill' => Yii::t('common', 'Is Seckill'),
            'seckill_status' => Yii::t('common', 'Seckill Status'),
            'is_group_buy' => Yii::t('common', 'Is Group Buy'),
            'is_published' => Yii::t('common', 'Is Published'),
            'create_at' => Yii::t('common', 'Create At'),
            'update_at' => Yii::t('common', 'Update At'),
            'last_update' => Yii::t('common', 'Last Update'),
            'description' => Yii::t('common', 'Description'),
            'content' => Yii::t('common', 'Content'),
            'detail' => Yii::t('common', 'Detail'),
            'images' => Yii::t('common', 'Images'),
            'address' => Yii::t('common', 'Address'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackageItems()
    {
        return $this->hasMany(PackageItem::className(), ['package_id' => 'id']);
    }
}
