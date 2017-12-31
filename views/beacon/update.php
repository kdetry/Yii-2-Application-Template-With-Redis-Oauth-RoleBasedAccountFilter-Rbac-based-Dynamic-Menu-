<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Device */

$this->title = 'Device Güncelle: '.$model->DeviceID;
$this->params['breadcrumbs'][] = ['label' => 'Devices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DeviceID, 'url' => ['view', 'id' => $model->DeviceID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="Device-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
