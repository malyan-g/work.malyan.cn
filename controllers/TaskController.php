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

        echo date('Y-m-d\TH:i:s\Z',strtotime('tomorrow 6am'));
        die;
        return $this->render('index');
    }

    /**
     * @return array
     */
    public function actionTaskList()
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $times = [];
        $times[] = [
            'id' => 1,
            'title' => '预出账',
            'startDate' => strtotime(date('Y-m-25 22:00:00')),
            'endDate' => strtotime(date('Y-m-26 23:59:59'))
        ];

        $times[] = [
            'id' => 2,
            'title' => '66彩铃月租',
            'startDate' => strtotime(date('Y-m-16 08:00:00')),
            'endDate' => strtotime(date('Y-m-16 23:59:59'))
        ];

        $events = [];

        foreach ($times AS $time){
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $time->id;
            $Event->title = $time->title;
            $Event->nonstandard = [
                'field1' => 'Something I want to be included in object #1',
                'field2' => 'Something I want to be included in object #2',
            ];
            $Event->start = date('Y-m-d\TH:i:s\Z',strtotime($time->startDate));
            $Event->end = date('Y-m-d\TH:i:s\Z',strtotime($time->endDate));
            $events[] = $Event;
        }

        return $events;
    }
}