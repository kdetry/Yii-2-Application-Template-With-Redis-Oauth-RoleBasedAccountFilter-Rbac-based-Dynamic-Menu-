<?php 

namespace app\controllers\base;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\RbacFilter;
use OauthEntity\OauthUser;
use OauthEntity\SessionUserEntity;
use yii\filters\AccessControl;


class BaseController extends Controller
{
	protected $primaryModel = '';
	protected $searchModel = '';
	protected $primaryModelName = '';
	protected $searchModelName = '';
	protected $ldap = array();
	CONST MODELNAMESPACE = 'app\models\\';
	
	/**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'rbac' => [
                'class' => RbacFilter::className()
            ],

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'logout'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login', 'logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }
	
    public function init($primaryModelName = '', $searchModelName = ''){
            $this->primaryModel = BaseController::MODELNAMESPACE.$primaryModelName;
            $this->primaryModelName = $primaryModelName;


            if($searchModelName == ''){
                    $searchModelName = $this->primaryModelName.'Search';
            }
            $this->searchModelName = $searchModelName;
            $this->searchModel = BaseController::MODELNAMESPACE.'searchmodels\\'.$searchModelName;
    }

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new $this->searchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	/**
	*
	* Ldap Connect Function
	*/
	public function ldapConnect(){
            $this->ldap['options'] = \Yii::$app->params['ldap'];
            $this->ldap['connection'] = ldap_connect($this->ldap['options']['host'], $this->ldap['options']['port']);
            ldap_set_option($this->ldap['connection'], LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($this->ldap['connection'], LDAP_OPT_REFERRALS, 0);
            if($this->ldap['connection'])
        
            try
            {
                $bind = ldap_bind($this->ldap['connection'], 
				$this->ldap['options']['uid'].','.$this->ldap['options']['dc'], 
				$this->ldap['options']['password']);
            }
            catch (Exception $e){
                \Yii::$app->getSession()->setFlash('info', $e->getMessage());
            }
        
	}
}