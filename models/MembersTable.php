<?php

namespace app\modules\leave\models;

use yii\db\Migration;

class MembersTable extends Migration
{
	public function up(){
		if(!$this->db->getTableSchema('leave_members')){
			$this->createTable('leave_members', [
				'member_id' => $this->bigPrimaryKey(),
				'user_id' => $this->bigInteger(),
				'department' => $this->string(),
				'email' => $this->string(),
				'level' => "ENUM('Master', 'Developer')",
			]);
		}
		return parent::up();
	}
}