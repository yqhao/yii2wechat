<?php
namespace frontend\modules\api\v1\controllers;

use common\models\PackageImage;
use frontend\modules\api\v1\resources\Package;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

/**
 * Class PackageController
 * @author Eugene Terentev <eugene@terentev.net>
 */
class PackageController extends ApiController
{
    /**
     * @var string
     */
    public $modelClass = 'frontend\modules\api\v1\resources\Package';

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
            'query' => Package::find()->published()->filterCategory($params)->orderBy(['updated_at' => SORT_DESC]),
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
        $model = Package::find()
            ->published()
            ->andWhere(['id' => (int) $id])
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }

        return ["data"=>$model];
    }
    public function actionDetail($id)
    {
        $model = Package::find()
            ->select('detail')
            ->published()
            ->andWhere(['id' => (int) $id])
            ->scalar();
        if (!$model) {
            throw new HttpException(404);
        }

        return ["data"=>$model];
    }
    public function actionImages($id)
    {
        $model = PackageImage::find()
            ->select('base_url,path')
            ->andWhere(['package_id'=>$id])
            ->orderBy('id ASC')
            ->all();
        if (!$model) {
            throw new HttpException(404,'页面不存在');
        }
        $list = [];
        foreach ($model as $value){
            $list[] = $value['base_url'].'/'.$value['path'];
        }
        return ["data"=>$list];
    }
}
