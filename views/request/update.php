<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\leave\models\LeaveRequest */

$this->title = 'Update Leave Request: ' . ' ' . $model->request_id;
$this->params['breadcrumbs'][] = ['label' => 'Leave Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->request_id, 'url' => ['view', 'id' => $model->request_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="leave-request-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'level' => $level,
        'users' => $users,
        'times' => $times,
    ]) ?>

</div>
