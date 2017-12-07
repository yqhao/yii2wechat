<?php

namespace backend\controllers;

use common\models\PackageCategory;
use Yii;
use common\models\Package;
use backend\models\search\PackageSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PackageController implements the CRUD actions for Package model.
 */
class PackageController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Package models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PackageSearch();
        $params = Yii::$app->request->queryParams;

        if(isset($params['PackageSearch']) && !empty($params['PackageSearch'])){
            if(isset($params['PackageSearch']['province_id'])){
                if($params['PackageSearch']['province_id'] && $params['PackageSearch']['province_id'] != 'empty'){
                    $params['province_id'] =(int)$params['PackageSearch']['province_id'];
                }
            }
            if(isset($params['PackageSearch']['city_id'])){
                if($params['PackageSearch']['city_id'] && $params['PackageSearch']['city_id'] != 'empty'){
                    $params['city_id'] =(int)$params['PackageSearch']['city_id'];
                }
            }
            if(isset($params['PackageSearch']['county_id'])){
                if($params['PackageSearch']['county_id'] && $params['PackageSearch']['county_id'] != 'empty'){
                    $params['county_id'] =(int)$params['PackageSearch']['county_id'];
                }
            }
        }



        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Package model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Package model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Package();
        $categories = PackageCategory::find()->noParents()->all();
        $categories = ArrayHelper::map($categories, 'id', 'title');
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categories' => $categories,
            ]);
        }
    }

    /**
     * Updates an existing Package model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $categories = PackageCategory::find()->noParents()->all();
        $categories = ArrayHelper::map($categories, 'id', 'title');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => $categories,
            ]);
        }
    }

    /**
     * Deletes an existing Package model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Package model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Package the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Package::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
}
