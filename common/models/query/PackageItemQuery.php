<?php

namespace common\models\query;


use common\models\Package;
use yii\db\ActiveQuery;

class PackageItemQuery extends ActiveQuery
{
    public function published()
    {
        $this->andWhere(['is_published' => Package::STATUS_PUBLISHED]);
        return $this;
    }
    public function filterPackage($params){
        if(isset($params['package_id'])){
            $this->andWhere(['package_id' => (int)$params['package_id']]);
        }
        return $this;
    }
}
