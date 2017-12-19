<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PackageItem;

/**
 * PackageItemSearch represents the model behind the search form about `common\models\PackageItem`.
 */
class PackageItemSearch extends PackageItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_id'], 'required'],
            [['id', 'package_id', 'sales', 'stock', 'weight', 'is_published', 'created_at', 'updated_at', 'last_update'], 'integer'],
            [['title', 'cover', 'content'], 'safe'],
            [['price', 'max_can_use_integral', 'integral'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PackageItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params,'') && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'package_id' => $this->package_id,
            'price' => $this->price,
//            'sales' => $this->sales,
//            'stock' => $this->stock,
//            'weight' => $this->weight,
//            'max_can_use_integral' => $this->max_can_use_integral,
//            'integral' => $this->integral,
            'is_published' => $this->is_published,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'last_update' => $this->last_update,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
//            ->andFilterWhere(['like', 'cover', $this->cover])
//            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
