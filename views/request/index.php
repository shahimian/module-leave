<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\leave\components\ConvertDate;
use app\models\User;
use app\modules\leave\widgets\calendar\CalendarJalali;
use app\modules\leave\widgets\miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\leave\models\LeaveRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leave Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-request-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?= CalendarJalali::widget([
    	'type' => 'jalali',
    	'date' => $date,
    ]) ?>

    <p>
        <?= Html::a('Create Leave Request', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'user_id' => [
				'value' => function($model){
					$user = (new User())->findIdentity($model->user_id);
					return $user->username;
				},
				'label' => 'User name',
			],
            'comment:ntext',
            'date' => [
				'value' => function($model){
					return $model->date;
				},
				'label' => 'Date',
			],
			'over_time',
            'start_time' => [
				'value' => function($model){
					return $model->start_time;
				},
				'label' => 'Start Time',
			],
            'finish_time' => [
				'value' => function($model){
					return $model->finish_time;
				},
				'label' => 'Finish Time',
			],
            'response',
            'delay',
            'created_by' => [
				'value' => function($model){
					return ConvertDate::gregorian_to_jalali(date('Y-m-d H:i:s', $model->created_by));
				},
				'label' => 'Created By',
			],
            'updated_by' => [
				'value' => function($model){
					return ConvertDate::gregorian_to_jalali(date('Y-m-d H:i:s', $model->updated_by));
				},
				'label' => 'Updated By',
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<?php
/*print_r($values);
$username = Yii::$app->user->identity->username;
$month_title = [];
for($i = 0; $i < 12; $i += 1)
	$monthtitle[$i] = $i + 1;
echo Highcharts::widget([
   'options' => array(
        'title' => array(
            'text' => "Leave $username chart",
        ),
        'xAxis' => array(
            'categories' => $month_title,
        ),
        'series' => array(
		[
			'type' => 'column',
			'name' => $username,
			'data' => $values,
		],
		[
			'type' => 'line',
			'name' => 'Leave',
			'data' => $values,
			'marker' => [
				'lineWidth' => 2,
				'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
				'fillColor' => 'white',
			],
		],
        ),        
    ),
]);
*/