<?php


namespace common\models\query;

use common\models\PackageCategory;
use yii\db\ActiveQuery;

class PackageCategoryQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['status' => PackageCategory::STATUS_ACTIVE]);

        return $this;
    }

    /**
     * @return $this
     */
    public function noParents()
    {
        $this->andWhere('{{wx_package_category}}.parent_id IS NULL');

        return $this;
    }
}
