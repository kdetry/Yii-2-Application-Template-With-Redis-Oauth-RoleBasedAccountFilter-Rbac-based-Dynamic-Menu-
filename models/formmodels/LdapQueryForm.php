<?php

namespace app\models\formmodels;

use Yii;
use yii\base\Model;
use app\models\LdapInfo;
/**
 * LDAP Form Modeli
 */
class LdapQueryForm extends Model
{

	public $ldapUserName;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['ldapUserName'], 'string', 'max' => 20]
        ];
    }
	
	public function getLdapUser($connection, $options){
		$sr   = ldap_search($connection, $options['dc'], '(uid='.$this->ldapUserName.')');
		$info = ldap_get_entries($connection, $sr);
		$isrol	= array();

		if(!count($info)){
			\Yii::$app->getSession()->setFlash('info', 'Kayıt Bulunamadı');
			return false;
		}

		for ($i = 0; $i < count($info[0]['isrol'])-1; $i++) {			
			if(strpos($info[0]['isrol'][$i], '[firstAppInfo]') > -1) {
				$isrol['firstAppInfo'] = $info[0]['isrol'][$i];
			}elseif(strpos($info[0]['isrol'][$i], '[secondAppInfo]') > -1 ) {
				$isrol['secondAppInfo'] = $info[0]['isrol'][$i];
			}
		}

		if(!isset($isrol['firstAppInfo'])){
			$isrol['firstAppInfo'] = '';
		}

		if(!isset($isrol['secondAppInfo'])){
			$isrol['secondAppInfo'] = '';
		}
		
		return array(
			'personalName'	=> $info[0]['displayname'][0],
			'personalIdentity'	=> $info[0]['personalIdentity'][0],
			'ldapUserName'	=> $this->ldapUserName,
			'firstAppInfo'		=> $isrol['firstAppInfo'],
			'secondAppInfo'		=> $isrol['secondAppInfo']
		);
	}
}