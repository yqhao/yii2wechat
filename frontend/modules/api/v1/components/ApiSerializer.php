<?php
/**
 * 重载\yii\rest\Serializer
 */

namespace frontend\modules\api\v1\components;

use Yii;
use yii\base\Arrayable;
use yii\base\Model;
use yii\data\DataProviderInterface;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Link;
use yii\web\Request;
use yii\web\Response;

class ApiSerializer extends \yii\rest\Serializer
{

    public $errorEnvelope = "error";

    protected function serializeModelErrors($model)
    {
        $this->response->setStatusCode(422, 'Data Validation Failed.');
        $result = [];
        foreach ($model->getFirstErrors() as $name => $message) {
            $result[] = [
                'field' => $name,
                'message' => $message,
            ];
        }

        if($this->errorEnvelope)
            return [$this->errorEnvelope => $result];
        return $result;
    }

}
