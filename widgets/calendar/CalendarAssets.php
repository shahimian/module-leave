<?php

namespace app\modules\leave\widgets\calendar;

use yii\web\AssetBundle;

class CalendarAssets extends AssetBundle
{
    public $sourcePath = '@app/modules/leave/widgets/calendar';
    public $baseUrl = 'app\modules\leave\widgets\calendar';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    	'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}