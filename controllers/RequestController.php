<?php

namespace app\modules\leave\controllers;

use Yii;
use app\modules\leave\models\LeaveRequest;
use app\modules\leave\models\LeaveAttendance;
use app\modules\leave\models\LeaveRequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\leave\components\ConvertDate;
use yii\filters\AccessControl;
use app\modules\leave\models\LeaveMembers;
use app\models\User;
use yii\data\ActiveDataProvider;


/**
 * RequestController implements the CRUD actions for LeaveRequest model.
 */
class RequestController extends Controller
{

	public $start = "08:00";
	public $finish = "17:00";
	public $duration = "30";

    public function behaviors()
    {
        return [
		'verbs' => [
			'class' => VerbFilter::className(),
			'actions' => [
			'delete' => ['post'],
			],
		],
		'access' => [
			'class' => AccessControl::className(),
			'only' => ['index', 'view', 'create', 'update', 'delete'],
			'rules' => [
				[
					'allow' => true,
					'actions' => ['index', 'view', 'create', 'update', 'delete'],
					'roles' => ['@'],
				],
			],            
		],
	];
    }

    /**
     * Lists all LeaveRequest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user_id = Yii::$app->user->id;
        $department = LeaveMembers::getDepartment();
        $level = LeaveMembers::getLevel();
        $where = ($level == "Developer" ? ['user_id' => $user_id] : ['user_id' => $this->membersDepartment($department)]);
        $query = LeaveRequest::find()->where($where);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $date = isset(Yii::$app->request->get()['date']) ? Yii::$app->request->get()['date'] : ConvertDate::gregorian_to_jalali(date('Y-m-d'));
    	$values = [];
    	$a = new LeaveAttendance();
    	$u = User::users();
    	foreach($u as $user){
    		array_push($values, $a->calculate($user['username']));
    	}
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'date' => $date,
            'values' => $values,
        ]);
    }
    
    public function membersDepartment($department){
    	$members = LeaveMembers::find()->where(['department' => $department])->asArray()->all();
    	$users = [];
    	foreach($members as $member){
    		array_push($users, $member['user_id']);
    	}
    	return $users;
    }
    
    public function users($department){
    	$users = [];
    	$members = $this->membersDepartment($department);
    	foreach($members as $id)
    		$users[$id] = User::findIdentity($id)->username;
        return $users;
    }

    /**
     * Displays a single LeaveRequest model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function times($start, $finish, $duration){
    	$box = [];
    	array_push($box, $start);
    	while($start < $finish){
    		$start_t = date('H:i', strtotime("+" . $duration . " minute", strtotime($start)));
    		$box[$start] = $start_t;
    		$start = $start_t;
    	}
    	return $box;
    }

    /**
     * Creates a new LeaveRequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LeaveRequest();
    	$model->setAttributes([
    		'user_id' => Yii::$app->user->id,
    		'date' => Yii::$app->request->get()['date'],
    		'over_time' => true,
    		'created_by' => time(),
    		'updated_by' => time(),
    		'response' => 'Considered',
    		'becoming' => true,
    	]);
        if ($model->load(Yii::$app->request->post())) {
			$model->setAttributes([
				'date' => $model->date,
				'start_time' => $model->start_time,
				'finish_time' => $model->finish_time,
				'delay' => $model->delay,
			]);
			if($model->save()){
				return $this->redirect(['view', 'id' => $model->request_id]);
			}
        } else {
            return $this->render('create', [
                'model' => $model,
                'level' => LeaveMembers::getLevel(),
                'users' => $this->users(LeaveMembers::getDepartment()),
                'times' => $this->times($this->start, $this->finish, $this->duration),
            ]);
        }
    }
    
    /**
     * Updates an existing LeaveRequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$model->setAttributes([
			'updated_by' => time(),
			'date' => $model->date,
			'start_time' => $model->start_time,
			'finish_time' => $model->finish_time,
		]);
        if ($model->load(Yii::$app->request->post())) {
			$model->setAttributes([
				'date' => $model->date,
				'start_time' => $model->start_time,
				'finish_time' => $model->finish_time,
				'delay' => $model->delay,
			]);
			if($model->save()){
				$member = LeaveMembers::find()->where(['user_id' => $model->user_id])->one();
				$response = $model->response;
				if(strlen($member->email) > 0){
					Yii::$app->mailer->compose()
						->setFrom('noreply@pixflow.net')
						->setTo($member->email)
						->setSubject('Leave Request')
						->setTextBody('Response: ' . $response)
						->setHtmlBody('Response: ' . $response)
						->send();			
				}
				return $this->redirect(['view', 'id' => $model->request_id]);
			}
        } else {
            return $this->render('update', [
                'model' => $model,
                'level' => LeaveMembers::getLevel(),
                'users' => $this->users(LeaveMembers::getDepartment()),
                'times' => $this->times($this->start, $this->finish, $this->duration),
            ]);
        }
    }

    /**
     * Deletes an existing LeaveRequest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LeaveRequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return LeaveRequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LeaveRequest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
