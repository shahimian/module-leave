<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\leave\models\LeaveRequestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-request-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'request_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'comment') ?>

    <?= $form->field($model, 'start_time') ?>

    <?= $form->field($model, 'finish_time') ?>

    <?php // echo $form->field($model, 'response') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
