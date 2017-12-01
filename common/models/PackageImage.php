<?php

namespace common\models;

use common\models\query\PackageImageQuery;
use Yii;

/**
 * This is the model class for table "wx_package_image".
 *
 * @property integer $id
 * @property integer $package_id
 * @property string $base_url
 * @property string $path
 * @property integer $created_at
 * @property integer $updated_at
 */
class PackageImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wx_package_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_id', 'path'], 'required'],
            [['package_id', 'created_at', 'updated_at'], 'integer'],
            [['base_url', 'path'], 'string', 'max' => 255],
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
            'base_url' => Yii::t('common', 'Base Url'),
            'path' => Yii::t('common', 'Path'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return PackageImageQuery
     */
    public static function find()
    {
        return new PackageImageQuery(get_called_class());
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['id' => 'package_id']);
    }
    public function getImageUrl()
    {
        return rtrim($this->base_url, '/') . '/' . ltrim($this->path, '/');
    }
}
