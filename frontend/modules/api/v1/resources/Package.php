<?php

namespace frontend\modules\api\v1\resources;

use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;


class Package extends \common\models\Package implements Linkable
{
    public function fields()
    {
        return ['id', 'category_id', 'title', 'description','cover', 'price', 'market_price','sales','is_recommend','stock','content','detail','address'];
    }


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
