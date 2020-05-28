<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/5/26
 * Time: 16:40
 */
/* @var $question \app\models\Question */
/* @var $questionAttr \app\models\QuestionAttr */

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

$isNewRecord = $question->isNewRecord;
$this->title = 'Question ' . ($isNewRecord ? 'Create' : 'Update');
$this->params['breadcrumbs'][] = ['label' => 'Question List', 'url' => ['question/list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin() ?>
<?= $form->field($questionAttr, 'describe')->widget('kucha\ueditor\UEditor',[
    'clientOptions' => [
        //编辑区域大小
        'initialFrameHeight' => '200',
        //设置语言
        'lang' =>'zh-cn', //中文为 zh-cn
    ]
]) ?>
<?= $form->field($questionAttr, 'comments') ?>
<?= $form->field($question, 'cate_id')->dropDownList(\app\models\QuestionCate::cateArray(), ['prompt' => '请选择']) ?>
<div class="form-group">
    <?= Html::submitButton($isNewRecord ? 'Create' : 'Update', ['class' => $isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end() ?>


