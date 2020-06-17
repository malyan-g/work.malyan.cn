<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/6/11
 * Time: 17:44
 */

namespace app\controllers;

use Yii;
/**
 * Class TaskController
 * @package app\controllers
 */
class TaskController extends Controller
{

    /**
     * 日常任务
     * @return string
     */
    public function actionIndex()
    {
        $events = [];

        $Event = new \yii2fullcalendar\models\Event();
        $Event->id = 1;
        $Event->title = 'Testing';
        $Event->start = date('Y-m-d\TH:i:s\Z');
        $Event->nonstandard = [
            'field1' => 'Something I want to be included in object #1',
            'field2' => 'Something I want to be included in object #2',
        ];
        $events[] = $Event;

        $Event = new \yii2fullcalendar\models\Event();
        $Event->id = 2;
        $Event->title = 'Testing';
        $Event->start = date('Y-m-d\TH:i:s\Z',strtotime('tomorrow 6am'));
        $events[] = $Event;

        return $this->render('index',[
            'events' => $events
        ]);
    }
}