<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $county
 * @property string $Longitude
 * @property string $latitude
 * @property string $type
 * @property integer $depth
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'depth'], 'integer'],
            [['name', 'province', 'city', 'county'], 'string', 'max' => 100],
            [['Longitude', 'latitude'], 'string', 'max' => 20],
            [['type'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'parent_id' => Yii::t('common', 'Parent ID'),
            'name' => Yii::t('common', 'Name'),
            'province' => Yii::t('common', 'Province'),
            'city' => Yii::t('common', 'City'),
            'county' => Yii::t('common', 'County'),
            'Longitude' => Yii::t('common', 'Longitude'),
            'latitude' => Yii::t('common', 'Latitude'),
            'type' => Yii::t('common', 'Type'),
            'depth' => Yii::t('common', 'Depth'),
        ];
    }
}
