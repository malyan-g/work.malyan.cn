<?php
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \app\models\search\QuestionCateSearch */

use yii\helpers\Url;
use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

$this->title = 'Cate List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="margin: 10px 0">
    <?= Html::a('Cate Create', ['question/cate-create'], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'question_name',
        //'user.real_name',
        'created_at:datetime',
        [
            'attribute' => 'id',
            'label' => '操作',
            'format' => 'raw',
            'enableSorting'=>false,
            'value' => function($model){
                $label = '';
                if($this->context->userId == $model->user_id){
                    $label = Html::a('Update', ['question/cate-update', 'id'=>$model->id], ['class'=>'btn btn-warning rt-mrt', 'target' => '_blank']);
                    $label .= Html::a('Delete',['question/cate-delete', 'id'=>$model->id], ['class'=>'btn btn-danger', 'data-confirm' => 'Confirm Delete?' ]);
                }

                return '<div class="btn-group">' . $label . '</div>';
            }
        ]
    ]
]) ?>
