<?php

namespace app\modules\leave\models;

use yii\db\Migration;

class AttendanceTable extends Migration
{
	public function up(){
		if(!$this->db->getTableSchema('leave_attendance')){
			$this->createTable('leave_attendance', [
				'attendance_id' => $this->bigPrimaryKey(),
				'user_id' => $this->bigInteger(),
				'time' => $this->string(),
				'date' => $this->string(),
				'eced' => "ENUM('EC', 'ED')"
			]);
		}
		return parent::up();
	}
}