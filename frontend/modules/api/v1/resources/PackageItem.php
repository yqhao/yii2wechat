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
            'id', 'package_id', 'title','cover', 'price','sale_price','weekend_price','holiday_price', 'sales','stock','content',
            'theDayAfterTomorrow' => function($model){
                return $model->getSalePriceByDate(strtotime('+2 day'));
            },
            'tomorrow' => function($model){
                return $model->getSalePriceByDate(strtotime('+1 day'));
            },
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
