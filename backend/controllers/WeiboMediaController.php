<?php

namespace backend\controllers;


use Yii;
use common\models\WeiboMedia;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Weibo;
use yii\helpers\Url;
/**
 * WeiboMediaController implements the CRUD actions for WeiboMedia model.
 */
class WeiboMediaController extends Controller
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
     * Lists all WeiboMedia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => WeiboMedia::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WeiboMedia model.
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
     * Creates a new WeiboMedia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
/*    public function actionCreate()
    {
        $model = new WeiboMedia();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }*/
    public function actionCreate()
    {
        $path = Yii::getAlias('@app').DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'dl'.DIRECTORY_SEPARATOR;
        $host = Yii::getAlias('@backendUrl');
        $model = new WeiboMedia();
        $Weibo = new Weibo();
        $medias = [];
        $mediasLocal = [];

        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post())){

            if($model->is_vedio){
                $medias = $Weibo->findPageMedia($Weibo->curl($model->page_url));
            }else{
                $medias = $Weibo->findPagePic($Weibo->curl($model->page_url));
            }

            if (!empty($medias))foreach ($medias as $fileName => $src){
                if($model->is_save){
                    $status = $Weibo->saveFile($src,$path.$fileName);
                    if($status){
//                        $mediasLocal[$fileName] = $host.'/dl/'.$fileName;
                        $mediasLocal[$fileName] = Url::to(['weibo-media/dl','filename'=>$fileName]);
                    }
                }
                //echo '<a target="_blank" href="'.$src.'">'.$src.'</a> - ok</br>';
            }
        }

        return $this->render('create', [
            'model' => $model,
            'mediasLocal' => $mediasLocal,
            'medias' => $medias
        ]);
    }

    public function actionDl($filename)
    {
        $path = Yii::getAlias('@app').DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'dl'.DIRECTORY_SEPARATOR;
        $filePath = $path.$filename;
        $fileinfo = pathinfo($filePath);
        //var_dump($fileinfo);exit;
        header('Content-type: application/x-'.$fileinfo['extension']);
        header('Content-Disposition: attachment; filename='.$fileinfo['basename']);
        header('Content-Length: '.filesize($filePath));
        readfile($filePath);
        exit();
//
//        header('Content-Description: File Transfer');
//
//        header('Content-Type: application/octet-stream');
//        header('Content-Disposition: attachment; filename='.basename($filePath));
//        header('Content-Transfer-Encoding: binary');
//        header('Expires: 0');
//        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//        header('Pragma: public');
//        header('Content-Length: ' . filesize($filePath));
//        readfile($filePath);
    }

    /**
     * Updates an existing WeiboMedia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WeiboMedia model.
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
     * Finds the WeiboMedia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WeiboMedia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WeiboMedia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
