<?php
/* @var $this yii\web\View */
/* @var $data array */
use yii\helpers\Html;

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
                    <a class="opr-toplist1-cut"><?= Html::encode($value['cate']['question_name']) ?></a>
                </span>
            </td>
            <td class="opr-toplist1-right opr-toplist1-right-hot">
                <?= Html::encode($value['total']) ?><i class="opr-toplist1-st c-icon "></i>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

