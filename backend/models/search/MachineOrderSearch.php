<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MachineOrder;

/**
 * MachineOrderSearch represents the model behind the search form about `common\models\MachineOrder`.
 */
class MachineOrderSearch extends MachineOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'franchisee_id', 'member_id', 'status', 'is_distributed', 'gai_discount', 'member_discount', 'create_time', 'machine_id', 'is_auto', 'distributed_time', 'pay_type'], 'integer'],
            [['entered_money', 'spend_money', 'point_money', 'distribute_money'], 'number'],
            [['remark', 'symbol', 'distribute_config', 'auto_check_fail', 'gai_number', 'order_key_id_str', 'gcp_order_code'], 'safe'],
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
        $query = MachineOrder::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'create_time' => SORT_DESC,
                ]
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'franchisee_id' => $this->franchisee_id,
            'member_id' => $this->member_id,
            'status' => $this->status,
            'is_distributed' => $this->is_distributed,
            'entered_money' => $this->entered_money,
            'spend_money' => $this->spend_money,
            'point_money' => $this->point_money,
            'gai_discount' => $this->gai_discount,
            'member_discount' => $this->member_discount,
            'distribute_money' => $this->distribute_money,
            'create_time' => $this->create_time,
            'machine_id' => $this->machine_id,
            'is_auto' => $this->is_auto,
            'distributed_time' => $this->distributed_time,
            'pay_type' => $this->pay_type,
        ]);

        $query->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'symbol', $this->symbol])
            ->andFilterWhere(['like', 'distribute_config', $this->distribute_config])
            ->andFilterWhere(['like', 'auto_check_fail', $this->auto_check_fail])
            ->andFilterWhere(['like', 'gai_number', $this->gai_number])
            ->andFilterWhere(['like', 'order_key_id_str', $this->order_key_id_str])
            ->andFilterWhere(['like', 'gcp_order_code', $this->gcp_order_code]);

        return $dataProvider;
    }
}
