<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Task List';
$routeData = ['task/index'];
?>
<?= \yii2fullcalendar\yii2fullcalendar::widget(['events'=> $events]);