<?php

namespace app\models;

use Yii;

/**
 * Bu class Redis üzerinden kullanıcı işlemlerini yürütmek için Createulmuştur.
 * Class User
 * @package app\models
 */
class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $sicilNo;
    public $kapiNo;
    public $operatorNo;
    public $garajKodu;
    public $authKey;
    public $accessToken;
    public $tokenExpiredTime;
    public $permissions;
    public $filters;
    public $iysRol;
    public $kadrolar;

    private static $users;

    /**
     * Bu metod redis üzerinde önceden tanımlanan attributlerle kullanıcı Createur
     */
    public function setUsers()
    {
        $redis = new \Predis\Client('tcp://'.Yii::$app->params['redis']['hostname'].':'.Yii::$app->params['redis']['port']);
        $redis->set('sp-token' . $this->accessToken, json_encode($this));
        $redis->pexpire('sp-token' . $this->accessToken, $this->tokenExpiredTime);
        $redis->set('sp-id' . $this->id, json_encode($this));
    }

    /**
     * Bu metod redis üzerindeki belirtilen idye sahip kullanıcının bilgilerini getirir.
     * @param int|string $id
     * @return static
     */
    public static function findIdentity($id)
    {
        $redis = new \Predis\Client('tcp://'.Yii::$app->params['redis']['hostname'].':'.Yii::$app->params['redis']['port']);
        $data = $redis->get('sp-id' . $id);
        return new static(json_decode($data));
    }

    /**
     * Bu metod kullanııcının identifysini redise update eder.
     * @param $identify
     */
    public static function updateUsers($identify)
    {
        $redis = new \Predis\Client('tcp://'.Yii::$app->params['redis']['hostname'].':'.Yii::$app->params['redis']['port']);
        $redis->set('sp-id' . \Yii::$app->user->id, json_encode($identify));
        \Yii::$app->user->setIdentity($identify);
    }


    /**
     * Bu metod token ile giriş yapılırken tokenın hangi kullanıcıya ait olduğunu bulup redisten o kullanıcının bilgilerini getirir.
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $redis = new \Predis\Client('tcp://'.Yii::$app->params['redis']['hostname'].':'.Yii::$app->params['redis']['port']);
        $tokenData = $redis->get('sp-token' . $token);
        $tokenData = json_decode($tokenData);
        $data = $redis->get('sp-id' . $tokenData->id);
        $return = json_decode($data);
        return new static($return);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Kullanıcının CRMden gelip gelmediğini döner
     * @return bool
     */
    public static function getIsCrm()
    {
        if(substr(\Yii::$app->user->identity->username,0,4 ) == 'crm_'){
            return true;
        }
        return false;
    }

    /**
     * Kullanıcının Şoför olup olmadığını döner
     * @return bool
     */
    public static function isSofor()
    {
        return \Yii::$app->OAuth2->checkPermission('KULLANICI/SOFOR');
    }

    /**
     * Kullanıcının OHOSirketi olup olmadığını döner
     * @return mixed
     */
    public static function isOHOSirketi()
    {
        return \Yii::$app->OAuth2->checkPermission('KULLANICI/OHOSIRKETI');
    }


}
