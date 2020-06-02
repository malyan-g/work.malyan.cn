<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/5/27
 * Time: 10:59
 */
/* @var  $dataProvider \yii\data\ActiveDataProvider */

use yii\widgets\ListView;
use app\widgets\JqueryIsa;

$this->title = 'Question Ranking List';
$this->params['breadcrumbs'][] = $this->title;

JqueryIsa::widget();
$number = 1;
?>
<!-- 列表 -->
<?= $dataProvider->query->count() ? ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => '<ul class="ranking-list">{items}</ul>{pager}',
    'itemView' => function($model){
        $html = '<li class="ranking-content">
                            <div class="ranking-title">
                                <span class="ranking-number">1</span>
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                <span>' . $model->user->real_name . '</span>
                                &nbsp;&nbsp;
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                <span>' . date('Y-m-d H:i:s', $model->created_at) . '</span>
                            </div>
                            <div class="ranking-describe">
                                ' . $model->attr->describe . '
                            </div>
                            <div class="ranking-comments">
                                ' . $model->attr->comments . '
                            </div>
                        </li>';
        return $html;
    }
]) : '' ?>
