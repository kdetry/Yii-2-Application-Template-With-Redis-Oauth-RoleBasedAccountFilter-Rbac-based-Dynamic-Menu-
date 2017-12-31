<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LDAP Form Modeli
 */
class LdapInfo extends Model
{
	public $personalName;
	public $personalIdentity;
	public $ldapUserName;
	public $firstAppInfo;
	public $secondAppInfo;
    public $oldFirstAppInfo;
    public $oldSecondAppInfo;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['personalName', 'personalIdentity', 'ldapUserName', 'oldFirstAppInfo', 'oldSecondAppInfo'], 'required'],
            [['personalName', 'personalIdentity', 'ldapUserName', 'firstAppInfo', 'secondAppInfo', 'oldFirstAppInfo', 'oldSecondAppInfo'], 'string', 'max' => 255]
        ];
    }
}