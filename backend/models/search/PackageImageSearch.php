<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PackageImage;

/**
 * PackageImageSearch represents the model behind the search form about `common\models\PackageImage`.
 */
class PackageImageSearch extends PackageImage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'package_id', 'created_at', 'updated_at'], 'integer'],
            [['base_url', 'path'], 'safe'],
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
        $query = PackageImage::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'package_id' => $this->package_id,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
        ]);

//        $query->andFilterWhere(['like', 'base_url', $this->base_url])
//            ->andFilterWhere(['like', 'path', $this->path]);

        return $dataProvider;
    }
}
