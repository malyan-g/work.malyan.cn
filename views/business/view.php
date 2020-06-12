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
<div class="business-header">
    <span class="business-title rt-mrt"><?= Html::encode($model->title) ?></span>
    <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
    <span><?= date('Y-m-d H:i:s', $model->created_at) ?></span>
</div>
<div class="business-content">
    <?= $model->content ?>
</div>
