<?php

namespace common\models;

use common\behaviors\CacheInvalidateBehavior;
use common\models\query\WidgetCarouselQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "widget_carousel".
 *
 * @property integer $id
 * @property string $key
 * @property integer $status
 * @property string $title
 *
 * @property WidgetCarouselItem[] $items
 */
class WidgetCarousel extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget_carousel}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'cacheInvalidate' => [
                'class' => CacheInvalidateBehavior::className(),
                'cacheComponent' => 'frontendCache',
                'keys' => [
                    function ($model) {
                        return [
                            self::className(),
                            $model->key
                        ];
                    }
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['key'], 'unique'],
            [['status'], 'integer'],
            [['key','title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'key' => Yii::t('common', 'Key'),
            'status' => Yii::t('common', 'Active'),
            'title' => Yii::t('common', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(WidgetCarouselItem::className(), ['carousel_id' => 'id'])
            ->select(["id","base_url","path","url"])
            ->orderBy(['order'=>SORT_ASC]);
    }
    /**
     * @return WidgetCarouselQuery
     */
    public static function find()
    {
        return new WidgetCarouselQuery(get_called_class());
    }
    

}
