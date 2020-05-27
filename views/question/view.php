<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/5/26
 * Time: 17:29
 */
/* @var $questionAttr \app\models\QuestionAttr */

use yii\bootstrap\Html;
?>
<?= Html::cssFile('@web/css/comm.css')?>
<div class="modal-question-content">
    <?= $questionAttr->describe ?>
</div>
