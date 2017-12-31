<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="ldap-index">
	<?php $form = ActiveForm::begin(['action' =>['ldap/find'], 'method' => 'post']); ?>

	<?= $form->field($model, 'ldapUserName')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
        <?= Html::submitButton('Sorgula', ['class' => 'btn btn-success']) ?>
    </div>
	<?php ActiveForm::end(); ?>

</div>