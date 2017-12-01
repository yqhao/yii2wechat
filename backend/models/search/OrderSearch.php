<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

/**
 * OrderSearch represents the model behind the search form about `common\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'package_id', 'total_quantity', 'created_at', 'updated_at', 'status', 'payment_type', 'payment_status', 'after_sale_status'], 'integer'],
            [['code', 'package_title', 'discount_info', 'coupon_code', 'contact_name', 'contact_mobile', 'remark'], 'safe'],
            [['total_price', 'total_sale_price', 'payment_price', 'discount'], 'number'],
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
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'package_id' => $this->package_id,
            'total_quantity' => $this->total_quantity,
            'total_price' => $this->total_price,
            'total_sale_price' => $this->total_sale_price,
            'payment_price' => $this->payment_price,
            'discount' => $this->discount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'payment_type' => $this->payment_type,
            'payment_status' => $this->payment_status,
            'after_sale_status' => $this->after_sale_status,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'package_title', $this->package_title])
            ->andFilterWhere(['like', 'discount_info', $this->discount_info])
            ->andFilterWhere(['like', 'coupon_code', $this->coupon_code])
            ->andFilterWhere(['like', 'contact_name', $this->contact_name])
            ->andFilterWhere(['like', 'contact_mobile', $this->contact_mobile])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
