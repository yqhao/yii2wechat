<?php

namespace frontend\modules\api\v1\resources;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;


class WidgetCarousel extends \common\models\WidgetCarousel implements Linkable
{
//    public function fields()
//    {
//        return ['id', 'url', 'image'=> function ($model) {
//            return $model->base_url . '/' . $model->path;
//        }, 'order'];
//    }

    public function extraFields()
    {
        return ['items','activeItems'];
    }

    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['widget-carousel/view', 'id' => $this->id], true)
        ];
    }
    
}
