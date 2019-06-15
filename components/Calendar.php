<?php

namespace app\modules\leave\components;

use app\modules\leave\components\ConvertDate;
use app\modules\leave\models\LeaveRequest;
use app\models\User;

class Calendar {

	function month($date){
		$convert = new ConvertDate();
		$gregorian = $convert->jalali_to_gregorian($date . '-01');
		$days_of_week = date('N', strtotime($gregorian));
		$days = array_fill(0, 5, []);
		$j = 0;
		$out = [6, 7, 1, 2, 3, 4, 5];
		$k = 0;
		while($out[$k] != $days_of_week){
			$days[$j][$out[$k]] = 0;
			$k += 1;
		}
		$users = LeaveRequest::find()->where([
			'response' => 'Accepted',
			'date' => $convert->gregorian_to_jalali($gregorian),
			'becoming' => 1,
		])->all();
		$request = [];
		foreach($users as $user){
			$duration = " ( " . ($user->over_time ? "Over time" : $user->start_time . "-" . $user->finish_time) . " )";
			array_push($request, [User::findIdentity($user->user_id)->username . $duration, $user->delay]);
		}
		$today_flag = date('Y-m-d') == $gregorian ? true : false;
		$days[$j][$days_of_week] = [1, $request, $today_flag];
		$gregorian_tommorow = date('Y-m-d', strtotime('+1 day', strtotime($gregorian)));
		$jalali_tommorow = $convert->gregorian_to_jalali($gregorian_tommorow);
		$i = 2;
		while($i <= 31 && explode('-', $jalali_tommorow)[1] == explode('-', $date)[1]) {
			if($days_of_week == 5)
				$j += 1;
			$current = $date . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
			$gregorian = $convert->jalali_to_gregorian($current);
			$days_of_week = date('N', strtotime($gregorian));
			$users = LeaveRequest::find()->where([
				'response' => 'Accepted',
				'date' => $current,
				'becoming' => 1,
			])->all();
			$request = [];
			foreach($users as $user){
				$duration = " ( " . ($user->over_time ? "Over time" : $user->start_time . "-" . $user->finish_time) . " )";
				array_push($request, [User::findIdentity($user->user_id)->username . $duration, $user->delay]);
			}
			$today_flag = date('Y-m-d') == $gregorian ? true : false;
			$days[$j][$days_of_week] = [$i, $request, $today_flag];
			$gregorian_tommorow = date('Y-m-d', strtotime('+1 day', strtotime($gregorian)));
			$jalali_tommorow = $convert->gregorian_to_jalali($gregorian_tommorow);
			$i += 1;
		};
		return $days;
	}

}