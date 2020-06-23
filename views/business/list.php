<?php
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \app\models\search\QuestionSearch */

use yii\bootstrap\Html;
use yii\grid\GridView;

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
                $title = $model->title;
                if($this->context->keywords){
                    $title = str_replace($this->context->keywords, "<span style='color: red'>" . $this->context->keywords. "</span>", $title);
                }
                return $title;
            }
        ],
        'sort',
        'created_at:datetime',
        [
            'attribute' => 'id',
            'label' => '操作',
            'format' => 'raw',
            'enableSorting'=>false,
            'value' => function($model){
                $label = Html::a('View', ['business/view', 'id'=>$model->id], ['class'=>'btn btn-info rt-mrt', 'target' => '_blank']);
                if($model->user_id == $this->context->userId || $model->id == $this->context->businessId){
                    $label .= Html::a('Update', ['business/update', 'id'=>$model->id], ['class'=>'btn btn-warning rt-mrt', 'target' => '_blank']);
                    if($model->id != $this->context->businessId){
                        $label .= Html::a('Delete',['business/delete', 'id'=>$model->id], ['class'=>'btn btn-danger', 'data-confirm' => 'Confirm Delete?' ]);
                    }
                }

                return '<div>' . $label . '</div>';
            }
        ]
    ]
]) ?>
