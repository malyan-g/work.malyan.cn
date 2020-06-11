<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/5/26
 * Time: 16:57
 */
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use app\widgets\Laydate;

/* @var $searchModel \app\models\search\QuestionSearch */
/* @var $searchType */

?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-inline btn-toolbar'], 'method' => 'get']) ?>
<?php if($searchType == 'list'): ?>
    <?= $form->field($question, 'cate_id')->dropDownList(\app\models\QuestionCate::cateArray(), ['prompt' => '请选择']) ?>
<?php endif; ?>
<?=  Laydate::widget(['form' => $form, 'model' => $searchModel, 'label' => '日期：', 'startDate' => 'startDate', 'endDate' => 'endDate']) ?>
&nbsp;
<div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-default']) ?>
</div>
<?php ActiveForm::end() ?>
<div class="hr dotted"></div>
