<?php

namespace app\modules\leave\widgets\calendar;

use yii\base\Widget;
use app\modules\leave\components\Calendar;

class CalendarJalali extends Widget {

	public $type;
	public $date;

	function run(){
		$date = explode('-', $this->date);
		$days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
		if($this->type == 'jalali')
			$days = ['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
		$calendar = new Calendar();
		return $this->render('index', [
			'days' => $days,
			'month' => $calendar->month("{$date[0]}-{$date[1]}"),
			'date' => $date[0] . '-' . $date[1],
		]);
	}

}
