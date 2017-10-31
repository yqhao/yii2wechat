<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Carousel;

/**
 * CarouselSearch represents the model behind the search form about `common\models\Carousel`.
 */
class CarouselSearch extends Carousel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_published'], 'integer'],
            [['compId', 'type', 'style', 'content', 'animations', 'customFeature', 'page_form'], 'safe'],
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
        $query = Carousel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'is_published' => $this->is_published,
        ]);

        $query->andFilterWhere(['like', 'compId', $this->compId])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'style', $this->style])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'animations', $this->animations])
            ->andFilterWhere(['like', 'customFeature', $this->customFeature])
            ->andFilterWhere(['like', 'page_form', $this->page_form]);

        return $dataProvider;
    }
}
