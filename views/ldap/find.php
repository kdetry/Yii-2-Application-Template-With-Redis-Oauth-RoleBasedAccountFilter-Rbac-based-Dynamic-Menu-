<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="ldap-index">
	<?php $form = ActiveForm::begin(['action' =>['ldap/save'], 'method' => 'post']); ?>
	<?= $form->field($model, 'personalName')->textInput(['maxlength' => true, 'readonly' => true]) ?>
	<?= $form->field($model, 'personalIdentity')->textInput(['maxlength' => true, 'readonly' => true]) ?>
	<?= $form->field($model, 'ldapUserName')->hiddenInput()->label(false) ?>
	<?= $form->field($model, 'firstAppInfo')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'secondAppInfo')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'oldFirstAppInfo')->hiddenInput()->label(false) ?>
	<?= $form->field($model, 'oldSecondAppInfo')->hiddenInput()->label(false)  ?>
	<div class="form-group">
        <?= Html::submitButton('Kaydet', ['class' => 'btn btn-success']) ?>
    </div>
	<?php ActiveForm::end(); ?>

</div>