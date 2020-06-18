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
        return $this->render('index');
    }

    /**
     * 日常任务数据
     * @return array
     */
    public function actionTaskData()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Yii::$app->request->getQueryParams();
        $taskData = [
            [
                'id' => 1,
                'title' => '预出账资料准备',
                'date' => 25,
                'limit' => 1,
                'startDate' => ' 22:00:00',
                'endDate' => ' 00:00:00',
                'color' => null
            ],
            [
                'id' => 2,
                'title' => '预出账',
                'date' =>26,
                'limit' => 0,
                'startDate' => ' 08:30:00',
                'endDate' => ' 18:00:00',
                'color' => '#d9534f'
            ],
            [
                'id' => 3,
                'title' => '66彩铃月租',
                'date' =>16,
                'limit' => 0,
                'startDate' => ' 08:30:00',
                'endDate' => ' 18:00:00',
                'color' => '#f0ad4e'
            ],
            [
                'id' => 4,
                'title' => '出账准备',
                'date' => 'max',
                'limit' => 1,
                'startDate' => ' 08:30:00',
                'endDate' => ' 00:00:00',
                'color' => null
            ],
            [
                'id' => 5,
                'title' => '出账',
                'date' => 1,
                'limit' => 0,
                'startDate' => ' 00:00:00',
                'endDate' => ' 08:00:00',
                'color' => '#d9534f'
            ]
        ];

        $i = false;
        $start = strtotime($data['start']);
        $end = strtotime($data['end']);
        $startDate = intval(date('Ym', $start));
        $endDate = intval(date('Ym', $end));
        $startDay = date('d', $start);
        $endDay = date('d', $end);
        $date = $startDate;
        $taskList = [];
        while ($i === false){
            $maxDate = date('d', strtotime($date . "01 +1 month -1 day"));
            foreach ($taskData as $val){
                if($val['date'] == 'max'){
                    $val['date'] = $maxDate;
                }
                if($startDate == $date){
                    if(intval($val['date']) >= intval($startDay)){
                        $_date = date('Y-m', strtotime($date. '01'));
                        $_sDate = $val['date'] > 9 ? $val['date'] : '0' . strval($val['date']);
                        $val['startDate'] = $_date . '-' . $_sDate . $val['startDate'];
                        $val['endDate'] = $val['limit'] > 0 ? date('Y-m-d', strtotime($_date . '-' . $_sDate . " + " . $val['limit'] . "day")) . $val['endDate']: $_date . '-' . $_sDate . $val['endDate'];
                        $taskList[] = $val;
                    }
                }elseif($endDate == $date){
                    if(intval($val['date']) <= intval($endDay)){
                        $_date = date('Y-m', strtotime($date. '01'));
                        $_sDate = $val['date'] > 9 ? $val['date'] : '0' . strval($val['date']);
                        $val['startDate'] = $_date . '-' . $_sDate . $val['startDate'];
                        $val['endDate'] = $val['limit'] > 0 ? date('Y-m-d', strtotime($_date . '-' . $_sDate . " + " . $val['limit'] . "day")) . $val['endDate']: $_date . '-' . $_sDate . $val['endDate'];
                        $taskList[] = $val;
                    }
                }else{
                    $_date = date('Y-m', strtotime($date. '01'));
                    $_sDate = $val['date'] > 9 ? $val['date'] : '0' . strval($val['date']);
                    $val['startDate'] = $_date . '-' . $_sDate . $val['startDate'];
                    $val['endDate'] = $val['limit'] > 0 ? date('Y-m-d', strtotime($_date . '-' . $_sDate . " + " . $val['limit'] . "day")) . $val['endDate']: $_date . '-' . $_sDate . $val['endDate'];
                    $taskList[] = $val;
                }
            }

            if($date < $endDate){
                $date = intval(date('Ym', strtotime($date . ' + 1 month')));
            }else{
                $i = true;
            }
        }

        $events = [];

        $Event = new \yii2fullcalendar\models\Event();
        foreach ($taskList as $task){
            $_Event = clone $Event;
            $_Event->id = $task['id'];
            $_Event->title = $task['title'];
            $_Event->nonstandard = [
                'field1' => 'Something I want to be included in object #1',
                'field2' => 'Something I want to be included in object #2',
            ];
            $_Event->start = $task['startDate'];
            $_Event->end = $task['endDate'];
            $_Event->color = $task['color'];
            $events[] = $_Event;
        }

        return $events;
    }
}
