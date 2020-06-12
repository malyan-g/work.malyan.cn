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

?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-inline btn-toolbar'], 'method' => 'get']) ?>
<?=  Laydate::widget(['form' => $form, 'model' => $searchModel, 'label' => '日期：', 'startDate' => 'startDate', 'endDate' => 'endDate']) ?>
<div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-default']) ?>
</div>
<?php ActiveForm::end() ?>
<div class="hr dotted"></div>
