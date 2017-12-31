<?php

namespace app\controllers;

use Yii;
use app\controllers\base;
use yii\web\NotFoundHttpException;
use app\models\formmodels\LdapQueryForm;
use app\models\LdapInfo;

class LdapController extends Base\BaseController
{
	
	public function init() {
		parent::init();
	}
	
	public function actionIndex(){
        $model = new LdapQueryForm();
		return $this->render('index', [
			'model' => $model,
		]);
	}
	
	public function actionFind(){
		$model = new LdapQueryForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {	
			$this->ldapConnect();
			$resultLdapUser = $model->getLdapUser($this->ldap['connection'], $this->ldap['options']);
			if(!$resultLdapUser){
				return $this->redirect(['ldap/index']);
			}
			$ldapYetki = new LdapInfo();
			$ldapYetki->attributes = $resultLdapUser;
			return $this->showFindForm($ldapYetki);
		}
		return $this->redirect(['ldap/index']);
	}
	
	public function actionSave(){
		$model = new LdapInfo();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {	
			$this->ldapConnect();
			$ldapQuery = ''.$model->ldapUserName.''; //LDAP QUERY HAS DELETED CAUSE OF SECURITY
			ldap_mod_del($this->ldap['connection'], $ldapQuery, array('isrol' => $model->oldFirstAppInfo));
			ldap_mod_del($this->ldap['connection'], $ldapQuery, array('isrol' => $model->oldSecondAppInfo));
			ldap_mod_add($this->ldap['connection'], $ldapQuery, array('isrol' => $model->firstAppInfo));
			ldap_mod_add($this->ldap['connection'], $ldapQuery, array('isrol' => $model->secondAppInfo));

			\Yii::$app->getSession()->setFlash('info', 'Kayıt Başarıyla Güncellendi.');
			return $this->redirect(['ldap/index']);
		}
		\Yii::$app->getSession()->setFlash('info', 'Kayıt Güncellenemedi. Lütfen Tekrar Deneyiniz');
		return $this->redirect(['ldap/index']);
	}

	private function showFindForm($ldapYetki) {
		return $this->render('find', array(
			'model' => $ldapYetki
		));
	}
	
	
	
}
