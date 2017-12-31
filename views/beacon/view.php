<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Device */

$this->title = $model->DeviceID;
$this->params['breadcrumbs'][] = ['label' => 'Devices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Device-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::a('Güncelle', ['update', 'id' => $model->DeviceID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Sil', ['delete', 'id' => $model->DeviceID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Silmek istediğinize Emin Misiniz ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'DeviceID',
            'DEVICETYPE',
            'DEVICECODE',
            'CREATEDTIME',
        ],
    ]) ?>

</div>
