<?php
/* @var $this yii\web\View */
/* @var $data array */
/* @var $total int */
/* @var $searchModel \app\models\search\QuestionSearch */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Question Ranking';
$routeData = ['question/cate-index'];

if($searchModel->startDate) {
    $routeData['QuestionSearch[startDate]'] = $searchModel->startDate;
}

if($searchModel->endDate){
    $routeData['QuestionSearch[endDate]'] = $searchModel->endDate;
}

$count = count($data);
?>
<?= $this->render('search', ['searchModel' => $searchModel]) ?>
<P></P>
<table class="c-table opr-toplist1-table col-lg-6">
    <tbody>
    <tr>
        <td>
            <strong><?= $this->title ?></strong>
        </td>
        <td class="opr-toplist1-right">
            <strong>
                Number <span class="badge"><?= $count ? $total : '' ?></span>
            </strong></td>
    </tr>
        <?php if($count > 0): ?>
            <?php foreach ($data as $key => $value): ?>
            <tr>
                <td>
                    <span>
                        <span class="c-index  c-index-hot<?= $key < 3 ?$key+1 : '' ?> c-gap-icon-right-small"><?= $key+1 ?></span>
                        <a href="<?= Url::toRoute(array_merge($routeData, ['QuestionSearch[cate_id]' => $value['cate_id']]))?>" class="opr-toplist1-cut question-modal" target="_blank"><?= Html::encode($value['cate']['question_name']) ?></a>
                    </span>
                </td>
                <td class="opr-toplist1-right opr-toplist1-right-hot">
                    <?= Html::encode($value['total']) ?><i class="opr-toplist1-st c-icon "></i>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                    <td style="border: 0">No results found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
