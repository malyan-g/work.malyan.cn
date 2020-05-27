<?php
/* @var $this yii\web\View */
/* @var $data array */
/* @var $searchModel \app\models\search\QuestionSearch */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;

$this->title = 'Question Ranking';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('search', ['searchModel' => $searchModel]) ?>
<P></P>
<table class="c-table opr-toplist1-table">
    <tbody>
    <tr>
        <td><?= $this->title ?></td>
        <td class="opr-toplist1-right">Number</td>
    </tr>
        <?php foreach ($data as $key => $value): ?>
        <tr>
            <td>
                <span>
                    <span class="c-index  c-index-hot<?= $key+1 ?> c-gap-icon-right-small"><?= $key+1 ?></span>
                    <a href="'javascript:void(0)" class="opr-toplist1-cut question-modal" data-toggle="modal" data-target="#question-modal" data-id="<?= $value['cate_id']?>"><?= Html::encode($value['cate']['question_name']) ?></a>
                </span>
            </td>
            <td class="opr-toplist1-right opr-toplist1-right-hot">
                <?= Html::encode($value['total']) ?><i class="opr-toplist1-st c-icon "></i>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
Modal::begin([
    'id' => 'question-modal',
    'header' => '<h4 class="modal-title">问题描述</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
]);
$requestUrl = Url::toRoute(['question/cate-index']);
$startDate = Html::getAttributeValue($searchModel,'startDate');
$endDate = Html::getAttributeValue($searchModel,'endDate');
$startDate = $startDate ? $startDate : 0;
$endDate = $endDate ? $endDate : 0;
var_dump($startDate);
$js = <<<JS
    $(".question-modal").click(function(){
        var id = $(this).data('id');
        var requestData = {cate_id: id};
        var startDate = {$startDate};
        var endDate = {$endDate};
        if(startDate){
            requestData.startDate = startDate;
        }
        
         if(endDate){
            requestData.endDate = endDate;
        }
        $.get('{$requestUrl}', requestData,
            function (data) {
                $('.modal-body').html(data);
            }  
        );
    });
JS;
$this->registerJs($js);
Modal::end();
?>
