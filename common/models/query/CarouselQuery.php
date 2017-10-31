<?php

namespace common\models\query;

use common\models\Carousel;
use yii\db\ActiveQuery;

class CarouselQuery extends ActiveQuery
{
    public function published()
    {
        $this->andWhere(['is_published' => Carousel::STATUS_PUBLISHED]);
        return $this;
    }
}
