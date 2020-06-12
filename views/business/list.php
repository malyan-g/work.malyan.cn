<?php
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \app\models\search\QuestionSearch */

use yii\helpers\Url;
use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

$this->title = 'Business List';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('search', ['searchModel' => $searchModel]) ?>
<div style="margin: 10px 0">
    <?= Html::a('Create Business', ['business/create'], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        [
            'attribute'=>'title',
            'format' => 'raw',
            'contentOptions' => ['style'=>'max-width:240px;'],
            'value' => function($model){
                return str_replace($model->title, $this->context->keywords, "<span style='color: red'>" . $this->context->keywords. "</span>");
            }
        ],
        'created_at:datetime',
        [
            'attribute' => 'id',
            'label' => '操作',
            'format' => 'raw',
            'enableSorting'=>false,
            'value' => function($model){
                $label = Html::a('View', 'javascript:void(0)', ['class'=>'btn btn-info business-modal', 'data-toggle' => 'modal', 'data-target' => '#business-modal', 'data-id' => $model->id]);
                if($this->context->userId == $model->user_id){
                    $label .= Html::a('Update', ['business/update', 'id'=>$model->id], ['class'=>'btn btn-warning', 'target' => '_blank']);
                    $label .= Html::a('Delete',['business/delete', 'id'=>$model->id], ['class'=>'btn btn-danger', 'data-confirm' => 'Confirm Delete?' ]);
                }

                return '<div class="btn-group">' . $label . '</div>';
            }
        ]
    ]
]) ?>

<?php
Modal::begin([
    'id' => 'business-modal',
    'header' => '<h4 class="modal-title">内容</h4>',
    'closeButton' => false
]);
$requestUrl = Url::toRoute(['business/view']);
$js = <<<JS
    $(".business-modal").click(function(){
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


