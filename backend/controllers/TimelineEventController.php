<?php

namespace backend\controllers;

use Yii;
use backend\models\search\TimelineEventSearch;
use yii\base\Exception;
use yii\web\Controller;

/**
 * Application timeline controller
 */
class TimelineEventController extends Controller
{
    public $layout = 'common';
    /**
     * Lists all TimelineEvent models.
     * @return mixed
     */
    public function actionIndex()
    {

//        phpinfo();
//        var_dump(Yii::$app->cache);
//        Yii::$app->queryCache->flush();
        try{
            Yii::$app->queryCache->set(
                'cache-test',
                array('time'=>time()),
                60
            );
            Yii::$app->queryCache->set(
                'cache-test1',
                array('time'=>time()),
                60
            );
            var_dump(Yii::$app->queryCache->get('cache-test'));
            var_dump(Yii::$app->queryCache->get('cache-test1'));
            Yii::$app->queryCache->remove('cache-test');
            var_dump(Yii::$app->queryCache->get('cache-test'));
            var_dump(Yii::$app->queryCache->get('cache-test1'));
        }catch (Exception $e){
            var_dump('eee');
            var_dump($e->getMessage());
        }
        exit;
        $searchModel = new TimelineEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder'=>['created_at'=>SORT_DESC]
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
