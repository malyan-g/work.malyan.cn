<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/6/2
 * Time: 17:22
 */

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\assets\ScrollTopAsset;

class ScrollTop extends Widget
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $view = $this->getView();
        ScrollTopAsset::register($view);
    }
    /**
     * @inheritdoc
     */
    public function run()
    {
        return Html::a(
            Html::tag(
                'i',
                '',
                ['class'=>'glyphicon glyphicon-menu-up bluezed-scroll-top-circle']
            ),
            '#',
            ['id'=>'btn-top-scroller', 'class'=>'bluezed-scroll-top']
        );
    }
}