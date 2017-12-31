<?php

namespace app\components;

use yii\base\Component;
use Yii;
/**
 * Created by PhpStorm.
 * User: mustafa
 * Date: 02.05.2017
 * Time: 12:10
 */
class RedisSetting extends Component
{
    protected $redis;

    function __construct(array $config = [])
    {
        $this->redis = new \Predis\Client('tcp://'.Yii::$app->params['redis']['hostname'].':'.Yii::$app->params['redis']['port']);
        parent::__construct($config);
    }

    public function set($key, $value)
    {
        $this->redis->hSet('firstAppInfo-ayarlar',$key,$value);
    }

    public function get($key)
    {
        return $this->redis->hget('firstAppInfo-ayarlar',$key);
    }


}