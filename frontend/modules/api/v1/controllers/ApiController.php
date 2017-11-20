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
//        'class' => 'frontend\modules\api\v1\components\ApiSerializer',
        'collectionEnvelope' => 'data'
    ];

    protected function serializeData($data)
    {
        $result = parent::serializeData($data);
        if(!empty($result['data'])){
            $this->response_status = 1;
        }
        $expend = [
            'status' => $this->response_status
        ];
//        if(!empty($result['_meta'])){
//            $expend['is_more'] = $result['_meta']['currentPage'] < $result['_meta']['pageCount'] ? 1 : 0;
//            $expend['count'] = $result['_meta']['totalCount'];
//            $expend['current_page'] = $result['_meta']['currentPage'];
//            $expend['total_page'] = $result['_meta']['pageCount'];
//            $expend['per_page'] = $result['_meta']['perPage'];
//        }

        return array_merge($result, $expend);
    }


}
