<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'Daily Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="btn-group">
    <button type="button" class="btn btn-info"></button>已执行
</div>
<div class="btn-group">
    <button type="button" class="btn btn-success"></button>正在执行
</div>
<div class="btn-group">
    <button type="button" class="btn btn-danger"></button>即将执行
</div>
<div class="btn-group">
    <button type="button" class="btn btn-waring"></button>未执行
</div>
<?= \yii2fullcalendar\yii2fullcalendar::widget([
    'options' => [
        'lang' => 'zh-cn',
    ],
    'clientOptions' => [
        'header' => [
            'left' => 'prev,next today',
            'right' => 'month,agendaWeek,agendaDay,listMonth'
        ],
        'selectable' => true,
        'selectHelper' => true,
        'droppable' => true,
        'editable' => true,
        //'defaultDate' => date('Y-m-d'),
        //'nowIndicator' => true,
        //'fixedWeekCount' => false,
        //'weekNumbers' => true,
        //'weekNumbersWithinDays' => true,
        //'titleFormat' => 'YYYY MMMM',
        'displayEventTime' => true,
        'displayEventEnd' => true,
        'timeFormat' => 'HH:mm'
    ],
    //'themeSystem' => 'standard',
    'events' => Url::to(['task/task-data'])
]);

