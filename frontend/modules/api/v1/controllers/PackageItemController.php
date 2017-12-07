<?php
namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\resources\PackageItem;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

/**
 * Class PackageItemController
 * @author Eugene Terentev <eugene@terentev.net>
 */
class PackageItemController extends ApiController
{
    /**
     * @var string
     */
    public $modelClass = 'frontend\modules\api\v1\resources\PackageItem';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => [$this, 'prepareDataProvider']
            ],
            'view' => [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'findModel' => [$this, 'findModel']
            ]
        ];

    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        $params = \Yii::$app->request->queryParams;
        return new ActiveDataProvider(array(
            'query' => PackageItem::find()->published()->filterPackage($params),
            //'pagination' => ['pageSize' => '2']
        ));
    }


    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws HttpException
     */
    public function findModel($id)
    {
        $model = PackageItem::find()
            ->published()
            ->andWhere(['id' => (int) $id])
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }
        $model->select_date = \Yii::$app->getRequest()->get('select_date',date("Y-m-d ",strtotime(' +1 day')));
        return ["data"=>$model];
    }
}
