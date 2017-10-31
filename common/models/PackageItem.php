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
 *
 * @property WxPackage $package
 */
class PackageItem extends \yii\db\ActiveRecord
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
            [['price', 'max_can_use_integral', 'integral'], 'number'],
            [['content'], 'string'],
            [['title', 'cover'], 'string', 'max' => 255],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Package::className(), 'targetAttribute' => ['package_id' => 'id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['id' => 'package_id']);
    }
}
