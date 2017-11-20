<?php
namespace frontend\modules\api\v1\controllers;

use common\models\WidgetCarouselItem;
use frontend\modules\api\v1\resources\Package;
use frontend\modules\api\v1\resources\WidgetCarousel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\ActiveQuery;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

/**
 * Class PackageController
 * @author Eugene Terentev <eugene@terentev.net>
 */
class WidgetCarouselController extends ApiController
{
    /**
     * @var string
     */
    public $modelClass = 'frontend\modules\api\v1\resources\WidgetCarousel';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => [$this, 'prepareDataProvider'],
            ],
            'view' => [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'findModel' => [$this, 'findModel']
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction'
            ]
        ];
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        return new ActiveDataProvider(array(
            'query' => WidgetCarousel::find()->published()->getIndexAd()->orderBy(['id' => SORT_DESC]),
            'pagination' => ['pageSize' => '1']
        ));
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws HttpException
     */
    public function findModel($id)
    {
        $model = WidgetCarousel::find()
            ->published()
            ->andWhere(['id' => (int) $id])
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }
        return ["data"=>$model];
    }

//    protected function serializeData($data)
//    {
//        $expend = [];
//        $result = parent::serializeData($data);
//        if(!empty($result['data']))foreach ($result['data'] as $key => $value){
//            if(!empty($value['items']))foreach ($value['items'] as $itemKey => $itemValue){
//                $itemValue['image_url'] = $itemValue['base_url'].'/'.$itemValue['path'];
//            }
//            $result['data'][$key] = $itemValue;
//        }
//        return $result;
//    }
}
