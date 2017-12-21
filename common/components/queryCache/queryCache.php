<?php
namespace common\components\queryCache;

use yii\base\Component;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Class QueryCache
 * @package common\components\QueryCache
 */
class QueryCache extends Component
{
    /**
     * @var string
     */
    public $cachePrefix = '_queryCache';
    /**
     * @var int
     */
    public $cachingDuration = 7200;

    /**
     * @var array Runtime values cache
     */
    private $values = [];

    private $cacheModelName= 'apcCache';

    /* @var $cacheModel \yii\caching\ApcCache */
    private $cacheModel = null;

    public function init()
    {
        $name = $this->cacheModelName;
        if(!isset(Yii::$app->$name)){
            throw new Exception('Components '.$name.' 未被定义');
        }
        $this->cacheModel = Yii::$app->$name;
    }

    /**
     * @param $key
     * @param $value
     * @param $duration
     * @return mixed
     */
    public function set($key, $value, $duration = null)
    {
        $setDuration = $duration !== null ? $duration : $this->cachingDuration;
        if($this->cacheModel->set($this->getCacheKey($key), $value, $setDuration)){
            $this->values[$key] = $value;
            return true;
        }
        return false;
    }

    /**
     * @param array $values
     */
    public function setAll(array $values)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function get($key)
    {
        $cacheKey = $this->getCacheKey($key);
        $value = ArrayHelper::getValue($this->values, $key, false) ?: $this->cacheModel->get($cacheKey);
        return $value;
    }

    /**
     * @param array $keys
     * @return array
     */
    public function getAll(array $keys)
    {
        $values = [];
        foreach ($keys as $key) {
            $values[$key] = $this->get($key);
        }
        return $values;
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return $this->get($key) !== null;
    }

    /**
     * @param array $keys
     * @return bool
     */
    public function hasAll(array $keys)
    {
        foreach ($keys as $key) {
            if (!$this->has($key)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $key
     * @return bool
     */
    public function remove($key)
    {

        $cacheKey = $this->getCacheKey($key);
        if($this->cacheModel->delete($cacheKey)){
            unset($this->values[$key]);
            return true;
        }
        return false;
    }

    /**
     * @param array $keys
     */
    public function removeAll(array $keys)
    {
        foreach ($keys as $key) {
            $this->remove($key);
        }
    }

    /**
     * @return bool
     */
    public function flush()
    {
        return $this->cacheModel->flush();
    }


    /**
     * @param $key
     * @return array
     */
    protected function getCacheKey($key)
    {
        return [
            __CLASS__,
            $this->cachePrefix,
            $key
        ];
    }
}
