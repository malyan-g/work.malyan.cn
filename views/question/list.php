<?php
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \app\models\search\QuestionSearch */

use yii\helpers\Url;
use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

$this->title = 'Question List';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('search', ['searchModel' => $searchModel]) ?>
<div style="margin: 10px 0">
    <?= Html::a('Create Question', ['question/create'], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'cate.question_name',
        [
            'attribute'=>'attr.comments',
            'contentOptions' => ['style'=>'max-width:240px;']
        ],
        //'user.real_name',
        'created_at:datetime',
        [
            'attribute' => 'id',
            'label' => '操作',
            'format' => 'raw',
            'enableSorting'=>false,
            'value' => function($model){
                $label = Html::a('View', 'javascript:void(0)', ['class'=>'btn btn-info rt-mrt question-modal', 'data-toggle' => 'modal', 'data-target' => '#question-modal', 'data-id' => $model->id]);
                if($this->context->userId == $model->user_id){
                    $label .= Html::a('Update', ['question/update', 'id'=>$model->id], ['class'=>'btn btn-warning rt-mrt', 'target' => '_blank']);
                    $label .= Html::a('Delete',['question/delete', 'id'=>$model->id], ['class'=>'btn btn-danger', 'data-confirm' => 'Confirm Delete?' ]);
                }

                return '<div>' . $label . '</div>';
            }
        ]
    ]
]) ?>

<?php
Modal::begin([
    'id' => 'question-modal',
    'header' => '<h4 class="modal-title">问题描述</h4>',
    'closeButton' => false
]);
$requestUrl = Url::toRoute(['question/view']);
$js = <<<JS
    $(".question-modal").click(function(){
        var id = $(this).data('id');
        $.get('{$requestUrl}', {id: id},
            function (data) {
                $('.modal-body').html(data);
            }  
        );
    });
JS;
$this->registerJs($js);
Modal::end();
?>


