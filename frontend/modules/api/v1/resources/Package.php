<?php

namespace frontend\modules\api\v1\resources;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;


class Package extends \common\models\Package implements Linkable
{
//    public function fields()
//    {
//        return ['*'];
////        return ['id', 'compId', 'type', 'style', 'content', 'animations','customFeature','page_form','is_published'];
//    }


    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['package/view', 'id' => $this->id], true)
        ];
    }
    
}
