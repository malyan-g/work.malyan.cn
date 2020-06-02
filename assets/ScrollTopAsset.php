<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/6/2
 * Time: 17:21
 */

namespace app\assets;

use yii\web\AssetBundle;

class ScrollTopAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/scroll-top.css',
    ];
    public $js = [
        'js/scroll-top.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}