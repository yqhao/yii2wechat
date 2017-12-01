<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderItem;

/**
 * OrderItemSearch represents the model behind the search form about `common\models\OrderItem`.
 */
class OrderItemSearch extends OrderItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'package_id', 'package_item_id', 'quantity'], 'integer'],
            [['package_item_title', 'use_date'], 'safe'],
            [['price', 'sale_price'], 'number'],
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
        $query = OrderItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'package_id' => $this->package_id,
            'package_item_id' => $this->package_item_id,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'quantity' => $this->quantity,
            'use_date' => $this->use_date,
        ]);

        $query->andFilterWhere(['like', 'package_item_title', $this->package_item_title]);

        return $dataProvider;
    }
}
