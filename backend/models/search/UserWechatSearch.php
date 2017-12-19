<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserWechat;

/**
 * UserWechatSearch represents the model behind the search form about `common\models\UserWechat`.
 */
class UserWechatSearch extends UserWechat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid', 'code', 'nickname', 'session_key', 'unionid', 'user_info', 'token', 'auth_key', 'remark'], 'safe'],
            [['user_id', 'created_at', 'updated_at', 'status', 'expire_at', 'logged_at'], 'integer'],
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
        $query = UserWechat::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder'=>['created_at'=>SORT_DESC]]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'expire_at' => $this->expire_at,
            'logged_at' => $this->logged_at,
        ]);

        $query->andFilterWhere(['like', 'openid', $this->openid])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'session_key', $this->session_key])
            ->andFilterWhere(['like', 'unionid', $this->unionid])
            ->andFilterWhere(['like', 'user_info', $this->user_info])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
