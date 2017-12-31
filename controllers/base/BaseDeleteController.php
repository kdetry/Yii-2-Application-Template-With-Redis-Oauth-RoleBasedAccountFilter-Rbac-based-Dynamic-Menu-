<?php 

namespace app\controllers\base;

use Yii;
use app\controllers\base;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class BaseDeleteController extends BaseViewController
{
	
	public function init($primaryModelName, $searchModelName = ''){
		parent::init($primaryModelName, $searchModelName);
	}

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */	
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		$result = $model->delete();
		
		if($result !== false){
			\Yii::$app->getSession()->setFlash('info', 'Kayıt Başarıyla Silindi.');
		}
		
        return $this->redirect([strtolower($this->primaryModelName).'/index']);
    }
}