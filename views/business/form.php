<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/5/26
 * Time: 16:40
 */
/* @var $model \app\models\Business */

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

$isNewRecord = $model->isNewRecord;
$this->title = 'Question ' . ($isNewRecord ? 'Create' : 'Update');
$this->params['breadcrumbs'][] = ['label' => 'Business List', 'url' => ['business/list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'title') ?>
<?= $form->field($model, 'content')->widget('kucha\ueditor\UEditor',[
    'clientOptions' => [
        //编辑区域大小
        'initialFrameHeight' => '200',
        //设置语言
        'lang' =>'zh-cn', //中文为 zh-cn
    ]
]) ?>
<div class="form-group">
    <?= Html::submitButton($isNewRecord ? 'Create' : 'Update', ['class' => $isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end() ?>
