<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/5/26
 * Time: 16:57
 */
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/* @var $searchModel \app\models\search\BusinessSearch */

?>
<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-inline btn-toolbar'],
    'method' => 'get',
    'fieldConfig' => [
        'template' => "{label} {input}",
    ]
]) ?>
<?= $form->field($searchModel, 'title', ['options' => ['class' => 'form-group rt-mrt']]) ?>
<div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-default']) ?>
</div>
<?php ActiveForm::end() ?>
<div class="hr dotted"></div>
