<?php

namespace common\models\query;

use common\models\Package;
use yii\db\ActiveQuery;

class PackageQuery extends ActiveQuery
{
    public function published()
    {
        $this->andWhere(['is_published' => Package::STATUS_PUBLISHED]);
        return $this;
    }
    public function filterCategory($params){
        if(isset($params['category_id'])){
            $this->andWhere(['category_id' => (int)$params['category_id']]);
        }
        return $this;
    }
}
