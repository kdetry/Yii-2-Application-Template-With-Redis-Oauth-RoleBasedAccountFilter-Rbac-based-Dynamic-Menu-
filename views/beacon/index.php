<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\searchmodels\DeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Devicelar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Device-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Device Create', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	<div class="clearfix"></div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'DeviceID',
			[
				'label' => 'DEVICETYPE',
				'value' => function($model){
					if($model['DEVICETYPE'] == '0'){
						return 'Durak';
					}
					return 'Araç';
				}
			],
            'DEVICECODE',
			[
				'label' => 'KAYIT ZAMANI',
				'value' => function($model){
					return $model['CREATEDTIME'];
//					$date = DateTime::createFromFormat("d#M#y H#i#s*A", $dataProvider['CREATEDTIME']);
//					return $date->format('d-m-Y');
				}
			],

            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view}{delete}'
			],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
