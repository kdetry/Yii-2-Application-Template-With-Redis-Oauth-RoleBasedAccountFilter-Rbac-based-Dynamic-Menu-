<?php

namespace app\components;

use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class RbacFilter extends ActionFilter
{
    private $Rbac = '';

    function __construct(OAuth2 $rbac)
    {
        parent::__construct();
        $this->Rbac = $rbac;
    }

    public function beforeAction($action)
    {
		if (!$this->Rbac->checkPermission('site/index')) {
			return Yii::$app->getResponse()->redirect(\Yii::$app->params['oauth2']['redirectUri']);
		}

        if ($this->Rbac->checkPermission($action->controller->route)) {
            return $action;
        } else {
           throw new ForbiddenHttpException(\Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }


}

