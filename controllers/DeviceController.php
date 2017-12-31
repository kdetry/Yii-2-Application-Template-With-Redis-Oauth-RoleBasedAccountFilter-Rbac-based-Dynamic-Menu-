<?php

namespace app\controllers;

use Yii;
use app\controllers\base;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;

/**
 * DeviceController implements the CRUD actions for Device model.
 */
class DeviceController extends Base\BaseDeleteController
{
	public function init() {
		parent::init('Device');
	}

    public function actionCreate()
    {
		$model = new \app\models\Device();
		$post = Yii::$app->request->post();
        if (isset($post['Device']) && !empty($post['Device'])) {
			$bindData = array();
			$count = count($post['Device']['DeviceID']);
			for($i = 0; $i < $count; $i++){
				$Device = new \app\models\Device();
				$bindData = array(
					'DeviceID' => $post['Device']['DeviceID'][$i],
					'DEVICECODE' => $post['Device']['DEVICECODE'],
					'DEVICETYPE' => $post['Device']['DEVICETYPE']
				);
				$postTemp = $post;
				$postTemp['Device'] = $bindData;
				if ($Device->load($postTemp) && $Device->checkByTipAndDEVICECODE() && $Device->save()) {
					\Yii::$app->getSession()->setFlash('info', $Device->DeviceID. ' Başarıyla Kaydedildi');
				}
			}
			return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

}
