<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/5/26
 * Time: 17:29
 */
/* @var $model \app\models\Business */
use yii\bootstrap\Html;

$this->title = 'Business View';
$this->params['breadcrumbs'][] = $this->title;

?>
<h3><?= Html::encode($model->title) ?></h3>
<div>
    <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
    <span><?= date('Y-m-d H:i:s', $model->created_at) ?></span>
</div>
<div class="modal-question-content">
    <?= $model->content ?>
</div>
