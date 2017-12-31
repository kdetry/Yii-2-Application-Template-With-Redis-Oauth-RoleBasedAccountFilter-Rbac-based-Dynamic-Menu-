<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Device */

$this->title = 'Device Create';
$this->params['breadcrumbs'][] = ['label' => 'Devices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Device-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
