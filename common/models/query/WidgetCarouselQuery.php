<?php

namespace common\models\query;

use common\models\WidgetCarousel;
use common\models\WidgetCarouselItem;
use yii\db\ActiveQuery;

class WidgetCarouselQuery extends ActiveQuery
{
    public function published()
    {
        $this->andWhere(['status' => WidgetCarousel::STATUS_ACTIVE]);
        return $this;
    }

    public function getIndexAd(){

        $this->andWhere(['key' => 'index-ad']);
        return $this;
    }
}
