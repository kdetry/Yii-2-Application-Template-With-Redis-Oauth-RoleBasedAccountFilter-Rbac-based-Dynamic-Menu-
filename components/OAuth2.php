<?php
/**
 * @link https://github.com/borodulin/yii2-oauth2-server
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-oauth2-server/blob/master/LICENSE
 */

namespace app\components;

use app\models\RbacPermission;
use Yii;
use yii\base\Component;

/**
 * Class OAuth2
 * @package app\components
 */
class OAuth2 extends Component
{
    public $permissions = [];

    /**
     * Rbac constructor.
     */
    function __construct()
    {
        if (\Yii::$app->session->get('permissions') == null) {
            $this->setDefaultPermissions();
        }else {
            $this->prepareSessionData();
        }
    }


    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param RbacPermission $permission
     */
    public function addPermission(RbacPermission $permission){

        if(!$this->checkPermission($permission)){
            array_push($this->permissions, $permission);
        }
        \Yii::$app->session->set('permissions', json_encode($this->permissions));
    }

    private function setDefaultPermissions(){
        $defaultPermissions = \Yii::$app->params['defaultPermissions'];
        foreach($defaultPermissions as $permission){
            $permissionModel = new RbacPermission();
            $permissionModel->code = $permission['code'];
            $permissionModel->name = $permission['name'];
            $this->addPermission($permissionModel);
        }
    }

    public function checkPermission($action)
    {
		//var_dump($action);
        foreach($this->permissions as $permission){
			//var_dump($permission->code);
            if($permission->code == $action){
                return true;
            }
        }
        return false;
    }

    private function prepareSessionData(){
        $this->permissions = json_decode(\Yii::$app->session->get('permissions')) ;
    }

}

