<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use League\OAuth2\Client\Provider\GenericProvider;
use app\models\RbacPermission;
use app\models\User;
use app\controllers\base;


class SiteController extends Base\BaseController
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

    //    $model = new LoginForm();

        $oauthProvider = new GenericProvider(Yii::$app->params['oauth2']);

        if (!isset($_GET['code'])) {
            $oauthurl = $oauthProvider->getAuthorizationUrl();
            Yii::$app->session->set('oauth2state', $oauthProvider->getState());

        } elseif (empty($_GET['state']) || ($_GET['state'] !== Yii::$app->session->get('oauth2state'))) {
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {

            try {
                $accessToken = $oauthProvider->getAccessToken('authorization_code', [
                    'code' => $_GET['code'],
                ]);

                $resourceOwner = $oauthProvider->getResourceOwner($accessToken);

                $request = $oauthProvider->getAuthenticatedRequest(
                    'GET',
                    '', //OAUTH2 ADRESS HAS DELETED
                    $accessToken
                );
                $permissions = $oauthProvider->getResponse($request);

				
                $user = $resourceOwner->toArray();

                if (isset($permissions['permissions'])) {
                    foreach ($permissions['permissions'] as $permission) {
                        $permissionModel = new RbacPermission();
                        $permissionModel->code = $permission['code'];
                        $permissionModel->name = $permission['name'];
                        Yii::$app->OAuth2->addPermission($permissionModel);
                    }
                } else {
                    \Yii::$app->getSession()->setFlash('warning', '<b>Yetki Yok!</b><br/>İşletme Yönetim Sistemi için size tanımlanmış herhangi bir izin bulunmamaktadır.');
                }
                $roller = explode(',', $user['IYSROL']);
                $iysRol = $roller[0];


                $users = [
                    'id' => $user['NKULLANICIID'],
                    'username' => $user['SKULLANICIADI'],
                    'sicilNo' => $user['SSICILNUMARASI'],
                    'accessToken' => $accessToken->getToken(),
                    'tokenExpiredTime' => $accessToken->getExpires(),
                    'iysRol' => $iysRol,
                    'kadrolar' => $roller,
                    'kapiNo' => [],
                    'permissions' => [
                        'code' => 'firstAppInfo',
                        'permissions' => Yii::$app->OAuth2->getPermissions()
                    ],
                ];
                $_user = User::findIdentity($user['NKULLANICIID']);
                if($_user->id){
                    $user = new User($users);
                    $user->filters = $_user->filters;
                    $user->setUsers();
                    $login = Yii::$app->user->loginByAccessToken($_user->accessToken);

                }else{
                    $user = new User($users);
                    $user->setUsers();
                    $login = Yii::$app->user->loginByAccessToken($accessToken->getToken());
                }

                exit(header('location:/'));
            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

                // Failed to get the access token or user details.
                exit($e->getMessage());

            }
        }

      // if ($model->load(Yii::$app->request->post()) && $model->login()) {
      //     return $this->goBack();
      // }

        return $this->redirect($oauthurl);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->session->destroy();
        Yii::$app->user->logout();
		return $this->redirect('' . \Yii::$app->params['url']); //OAUTH2 REDIRECT ADRESİ SİLİNMİŞTİR

    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}