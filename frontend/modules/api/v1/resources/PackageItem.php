<?php

namespace frontend\modules\api\v1\resources;

use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;


class PackageItem extends \common\models\PackageItem implements Linkable
{
    public function fields()
    {
        return [
            'id', 'package_id', 'title','cover', 'price','market_price','weekend_price','holiday_price', 'sales','stock',
            'detail',
            'special_description',
            'unsubscribe_rules',
            'change_rules',
            'important_clause',
            'theDayAfterTomorrow' => function($model){
                return $model->getPriceByDate(strtotime($model->select_date.' +2 day'));
            },
            'tomorrow' => function($model){
                return $model->getPriceByDate(strtotime($model->select_date.' +1 day'));
            },
            'select_date'
        ];
    }


    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['PackageItem/view', 'id' => $this->id], true)
        ];
    }

}
