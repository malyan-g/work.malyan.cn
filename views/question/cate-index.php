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
?>
<!-- 列表 -->
<?= $dataProvider->query->count() ? ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => '<ul class="ranking-list">{items}</ul>{pager}',
    'itemView' => function($model){
        $html = '<li class="ranking-content">
                            <div class="ranking-title">
                                <span>' . $model->user->real_name . '</span>
                                <span>' . $model->created_at . '</span>
                            </div>
                            <div class="ranking-describe">
                                ' . $model->attr->describe . '
                            </div>
                        </li>';
        return $html;
    }
]) : '' ?>
