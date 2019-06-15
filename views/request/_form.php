<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\leave\models\LeaveRequest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-request-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if($level != "Developer"): ?>
    
    <?= $form->field($model, 'becoming')->checkBox() ?>
    
    <?= $form->field($model, 'user_id')->dropDownList($users) ?>
    
    <?php endif; ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?= $form->field($model, 'over_time')->checkBox() ?>
    
    <p>Start and end time: For example: 09:45 and 15:30</p>

    <?= $form->field($model, 'start_time')->dropDownList($times) ?>

    <?= $form->field($model, 'finish_time')->dropDownList($times) ?>
    
    <?php if($level != "Developer"): ?>
    
    <?= $form->field($model, 'response')->dropDownList([ 'Considered' => 'Considered', 'Refused' => 'Refused', 'Accepted' => 'Accepted', ], ['prompt' => '']) ?>
    
    <?php endif; ?>
    
    <?= $form->field($model, 'delay')->checkBox() ?>    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
