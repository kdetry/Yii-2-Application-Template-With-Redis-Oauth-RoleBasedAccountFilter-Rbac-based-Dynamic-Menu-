<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\searchmodels\DeviceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="Device-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'DeviceID') ?>

    <?= $form->field($model, 'DEVICETYPE') ?>

    <?= $form->field($model, 'DEVICECODE') ?>

    <?= $form->field($model, 'CREATEDTIME') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
