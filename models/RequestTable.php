<?php

namespace app\modules\leave\models;

use yii\db\Migration;

class RequestTable extends Migration
{
	public function up(){
		if(!$this->db->getTableSchema('leave_request')){
			$this->createTable('leave_request', [
				'request_id' => $this->bigPrimaryKey(),
				'user_id' => $this->bigInteger(),
				'comment' => $this->text(),
				'date' => $this->string(10),
				'over_time' => $this->boolean(),
				'start_time' => $this->string(8),
				'finish_time' => $this->string(8),
				'response' => "ENUM('Considered', 'Refused', 'Accepted')",
				'becoming' => $this->boolean(),
				'delay' => $this->boolean(),
				'created_by' => $this->integer(),
				'updated_by' => $this->integer(),
			]);
		}
		return parent::up();
	}
}