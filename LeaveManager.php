<?php

namespace app\modules\leave;
use app\modules\leave\models\RequestTable;
use app\modules\leave\models\MembersTable;
use app\modules\leave\models\AttendanceTable;


class LeaveManager extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\leave\controllers';

    public function init()
    {
		(new RequestTable())->up();
		(new MembersTable())->up();
		(new AttendanceTable())->up();
		parent::init();
    }
}
