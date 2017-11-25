<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Package;

/**
 * PackageSearch represents the model behind the search form about `common\models\Package`.
 */
class PackageSearch extends Package
{
    public $category_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'sales', 'is_recommend', 'stock', 'weight', 'goods_type', 'express_rule_id', 'is_seckill', 'seckill_status', 'is_group_buy', 'is_published', 'create_at', 'update_at', 'last_update'], 'integer'],
            [['app_id', 'title', 'cover', 'description', 'content', 'detail', 'images', 'address'], 'safe'],
            [['price', 'market_price', 'max_can_use_integral', 'integral'], 'number'],
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
        $query = Package::find();
//        $query->joinWith(['packageCategory']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'sales' => $this->sales,
            'is_recommend' => $this->is_recommend,
            'stock' => $this->stock,
            'weight' => $this->weight,
            'goods_type' => $this->goods_type,
            'max_can_use_integral' => $this->max_can_use_integral,
            'integral' => $this->integral,
            'express_rule_id' => $this->express_rule_id,
            'is_seckill' => $this->is_seckill,
            'seckill_status' => $this->seckill_status,
            'is_group_buy' => $this->is_group_buy,
            'is_published' => $this->is_published,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
            'last_update' => $this->last_update,
        ]);

        $query->andFilterWhere(['like', 'app_id', $this->app_id])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'cover', $this->cover])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'detail', $this->detail])
            ->andFilterWhere(['like', 'images', $this->images])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
