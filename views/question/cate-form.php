<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/5/26
 * Time: 16:40
 */
/* @var $model \app\models\QuestionCate */

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

$isNewRecord = $model->isNewRecord;
$this->title = 'Cate ' . ($isNewRecord ? 'Create' : 'Update');
$this->params['breadcrumbs'][] = ['label' => 'Cate List', 'url' => ['question/cate-list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'question_name') ?>
<div class="form-group">
    <?= Html::submitButton($isNewRecord ? 'Create' : 'Update', ['class' => $isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end() ?>
