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
    'layout' => '<ul class="question-list">{items}</ul>{pager}',
    'itemView' => function($model){
        var_dump($model);die;
        $html = '<li class="ranking-content">
                                    <div class="question-title">
                                        <span>' . $model->user->real_name . '</span>
                                        <span>' . $model->created_at . '</span>
                                    </div>
                                    <div class="question-describe">
                                        ' . $model->attr->describe . '
                                    </div>
                                </table>
                            </div>
                        </li>';
        return $html;
    }
]) : '' ?>
