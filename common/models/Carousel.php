<?php

namespace common\models;

use common\models\query\CarouselQuery;
use Yii;

/**
 * This is the model class for table "carousel".
 *
 * @property integer $id
 * @property string $compId
 * @property string $type
 * @property string $style
 * @property string $content
 * @property string $animations
 * @property string $customFeature
 * @property string $page_form
 * @property integer $is_published
 */
class Carousel extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wx_carousel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['style', 'content', 'animations'], 'string'],
            [['is_published'], 'integer'],
            [['compId', 'type'], 'string', 'max' => 50],
            [['customFeature', 'page_form'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'compId' => Yii::t('common', 'Comp ID'),
            'type' => Yii::t('common', 'Type'),
            'style' => Yii::t('common', 'Style'),
            'content' => Yii::t('common', 'Content'),
            'animations' => Yii::t('common', 'Animations'),
            'customFeature' => Yii::t('common', 'Custom Feature'),
            'page_form' => Yii::t('common', 'Page Form'),
            'is_published' => Yii::t('common', 'Is Published'),
        ];
    }

    /**
     * @return CarouselQuery
     */
    public static function find()
    {
        return new CarouselQuery(get_called_class());
    }
    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $this->content = @json_decode($this->content, true);
        $this->customFeature = @json_decode($this->customFeature, true);
        parent::afterFind();
    }
}
