<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Device */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="Device-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'DeviceID[]')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'DeviceID[]')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'DeviceID[]')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'DEVICETYPE') ->dropDownList(
			[ '0' => 'FirstValue', '1' => 'SecondValue' ],
			['prompt'=>'Make Choice']    // options
        ); ?>

    <?= $form->field($model, 'DEVICECODE')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'CREATEDTIME')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Kaydet', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
