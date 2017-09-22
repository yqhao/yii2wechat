<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Machine;

/**
 * MachineSearch represents the model behind the search form about `common\models\Machine`.
 */
class MachineSearch extends Machine
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_id', 'city_id', 'dist_id', 'order_count'], 'integer'],
            [['m_code', 'm_name', 'city_name', 'dist_name', 'street', 'last_time'], 'safe'],
            [['max_amount', 'order_amount'], 'number'],
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
        $query = Machine::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'last_time' => SORT_DESC,
                ]
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'm_id' => $this->m_id,
//            'last_time' => $this->last_time,
            'max_amount' => $this->max_amount,
            'city_id' => $this->city_id,
            'dist_id' => $this->dist_id,
//            'order_count' => $this->order_count,
//            'order_amount' => $this->order_amount,
        ]);

        $query->andFilterWhere(['like', 'm_code', $this->m_code])
            ->andFilterWhere(['like', 'm_name', $this->m_name])
            ->andFilterWhere(['like', 'city_name', $this->city_name])
            ->andFilterWhere(['like', 'dist_name', $this->dist_name])
            ->andFilterWhere(['like', 'street', $this->street]);

        $last_time = strtotime($this->last_time);
        if($this->last_time && $last_time>1451577600){
            $query->andFilterWhere(['between', 'last_time',
                date("Y-m-d 00:00:00",$last_time),
                date("Y-m-d 23:59:59",$last_time)]);
        }

        return $dataProvider;
    }
}
