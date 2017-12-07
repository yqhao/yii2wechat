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
        return ['id', 'category_id', 'title', 'description',
                'cover'=> function($model){
                return $model->getCover();
            },
            'price', 'market_price','sales','is_recommend','stock',
            'has_detail' => function($model){
                return trim($model->detail) ? 1 :0;
            },
            'purchase_notice','traffic_guide',
            'address'=> function($model){
                return $model->getFullAddress();
            }];
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
