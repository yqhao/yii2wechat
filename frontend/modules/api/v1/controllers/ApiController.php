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
    public $response_status = 0;
    /**
     * @var array
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data'
    ];

    protected function serializeData($data)
    {
        $result = parent::serializeData($data);
        return array_merge($result, ['status' => $this->response_status]);
    }


}
