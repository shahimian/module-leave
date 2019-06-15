<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\leave\components\ConvertDate;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\modules\leave\models\LeaveRequest */

$this->title = $model->request_id;
$this->params['breadcrumbs'][] = ['label' => 'Leave Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-request-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->request_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->request_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'request_id',
            [
				'label' => 'User Name',
				'value' => (new User())->findIdentity($model->user_id)->username,
			],
            'comment:ntext',
			[
				'label' => 'Date',
				'value' => $model->date,
			],
			'over_time',
			[
				'label' => 'Start Time',
				'value' => $model->start_time,
			],
			[
				'label' => 'Finish Time',
				'value' => $model->finish_time,
			],
            'response',
			[
				'label' => 'Created By',
				'value' => ConvertDate::gregorian_to_jalali(date('Y-m-d H:i:s', $model->created_by)),
			],
			[
				'label' => 'Updated By',
				'value' => ConvertDate::gregorian_to_jalali(date('Y-m-d H:i:s', $model->updated_by)),
			],
        ],
    ]) ?>

</div>
