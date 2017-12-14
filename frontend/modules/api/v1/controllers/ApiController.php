<?php
namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\resources\Carousel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

/**
 * Class CarouselController
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ApiController extends ActiveController
{
    public $response_status = null;
    /**
     * @var array
     */
    public $serializer = [
//        'class' => 'yii\rest\Serializer',
        'class' => 'frontend\modules\api\v1\components\ApiSerializer',
        'collectionEnvelope' => 'data'
    ];

    protected function serializeData($data)
    {
        $status = 0;
        $result = parent::serializeData($data);
        if(!empty($result[$this->serializer['collectionEnvelope']])){
            $status = 1;
        }
        if($this->response_status !== null){
            $status = $this->response_status;
        }
        $expend = [
            'status' => $status
        ];

        return array_merge($result, $expend);
    }


}
