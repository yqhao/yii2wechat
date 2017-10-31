<?php

namespace frontend\modules\api\v1\resources;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;


class Carousel extends \common\models\Carousel implements Linkable
{
    public function fields()
    {
        return ['id', 'compId', 'type', 'style', 'content', 'animations','customFeature','page_form','is_published'];
    }


    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['carousel/view', 'id' => $this->id], true)
        ];
    }
}
