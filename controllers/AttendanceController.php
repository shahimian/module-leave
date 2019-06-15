<?php

namespace app\modules\leave\controllers;
use Yii;
use app\modules\leave\models\LeaveAttendance;

class AttendanceController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$path = "uploads/CP170106.TXT";
    	$myfile = fopen($path, "r") or die("Unable to open file!");
    	$file = fread($myfile,filesize($path));
    	fclose($myfile);
    	$file = str_replace("\"", "", $file);
    	$file = str_replace("/", "-", $file);
    	$arr = explode("\n", $file);
    	$arr2 = [];
    	foreach($arr as $a){
    		$a = explode(",", $a);
    		if(count($a) != 6)
    			break;
    		$attendance = new LeaveAttendance();
    		$attendance->setAttributes([
    			'user_id' => intval($this->string2int($a[0])),
    			'time' => $a[1],
    			'date' => $a[2],
    			'eced' => $a[3],
    		]);
    		$attendance->save();
    	}
        return $this->render('index');
    }
    
    public function string2int($n){
    	for($i = 0; $i < 10; $i += 1){
    		if(substr($n, 0, 1) == "0"){
    			$n = substr($n, 1);
    			continue;
    		}
    		break;			
    	}
    	return $n;
    }

}
