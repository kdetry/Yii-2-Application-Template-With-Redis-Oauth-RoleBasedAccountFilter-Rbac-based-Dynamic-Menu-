<?php 

namespace app\controllers\base;

use Yii;
use app\controllers\base;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class BaseViewController extends BaseController
{
	
	public function init($primaryModelName, $searchModelName = ''){
		parent::init($primaryModelName, $searchModelName);
	}
	
    /**
     * Displays a single model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
	
    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
		$p = $this->primaryModel;
        if (($model = $p::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}