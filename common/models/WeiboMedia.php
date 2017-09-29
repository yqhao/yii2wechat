<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "weibo_media".
 *
 * @property integer $id
 * @property string $page_url
 * @property string $media_url
 * @property string $save_path
 * @property integer $is_save
 * @property integer $is_vedio
 */
class WeiboMedia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'weibo_media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_url', 'media_url', 'save_path'], 'string'],
            [['is_save', 'is_vedio'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'page_url' => Yii::t('common', 'Page Url'),
            'media_url' => Yii::t('common', 'Media Url'),
            'save_path' => Yii::t('common', 'Save Path'),
            'is_save' => Yii::t('common', 'Is Save'),
            'is_vedio' => Yii::t('common', 'Is Vedio'),
        ];
    }
}
