<?php

namespace app\modules\leave\models;

use Yii;

/**
 * This is the model class for table "leave_attendance".
 *
 * @property integer $attendance_id
 * @property integer $user_id
 * @property string $time
 * @property string $date
 * @property string $eced
 */
class LeaveAttendance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leave_attendance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['eced'], 'string'],
            [['time', 'date'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attendance_id' => 'Attendance ID',
            'user_id' => 'User ID',
            'time' => 'Time',
            'date' => 'Date',
            'eced' => 'Eced',
        ];
    }
    
    public function calculate($uid){
    	$attendance = LeaveAttendance::find([
    		'user_id' => $uid
    	])->asArray()->all();
    	$s = 0;
    	for($i = 0; $i < count($attendance); $i += 2){
		$start = date_create($attendance[$i]['time']);
		$end = date_create($attendance[$i+1]['time']);
		$diff = date_diff($end,$start);
		$s += $diff->h * 3600 + $diff->m * 60 + $diff->s;
    	}
    	return round($s / 3600);
    }    
    
}
