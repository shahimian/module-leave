<?php
use app\modules\leave\widgets\calendar\CalendarAssets;
use yii\helpers\Url;
use yii\helpers\Html;
CalendarAssets::register($this);
$js=<<<JS
$('table.calendar-jalali tr:not(:first-child) td').click(function(){
	var d = "$date-" + String("00" + $(this).attr('data')).slice(-2).toString();
	$('a[href*="create"]').attr('href', 'http://demo.parsprovider.com/basic/web/index.php?r=leave/request/create&date=' + d);
})
JS;
$this->registerJs($js , \yii\web\View::POS_END, 'active-date');
?>
<center>
<?php
for($i = 1; $i <= 12; $i += 1){
	$d = '1396-' . str_pad($i, 2, '00', STR_PAD_LEFT) . '-01';
	echo Html::a($i, ['index', 'date' => $d], ['class' => 'month']);
}
?>
</center>
<table class="calendar-jalali" cellspacing="10">
<tbody>
	<tr>
		<?php foreach($days as $day): ?>
		<td><?= $day ?></td>
		<?php endforeach; ?>
	</tr>
	<?php foreach($month as $week): ?>
	<tr>
		<?php foreach($week as $i => $day_of_week): ?>
		<td<?= !$day_of_week[0] ? " class=\"deactive\"" : ($i == 5 ? " class=\"off\"" : ($day_of_week[2] ? " class=\"today\"" : null)) ?> data="<?= $day_of_week[0] ?>">
		<?php
			echo $day_of_week[0] ? $day_of_week[0] : null;
			if(isset($day_of_week[1])):
			?>
			<div>
			<?php
				foreach($day_of_week[1] as $request):
				?><p<?php if($request[1]): ?> style="background: #d02141; color: #eaeaea; padding-left: 5px;"<?php endif; ?>>
				<?= $request[0] ?></p>
				<?php				
				endforeach;
			endif; ?>
			</div>
		</td>
		<?php endforeach; ?>
	</tr>
	<?php endforeach; ?>
</tbody>
</table>
