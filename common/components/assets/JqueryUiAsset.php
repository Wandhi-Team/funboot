<?php

namespace common\components\assets;

/**
 * https://jqueryui.com/
 * @package common\components\assets
 * @author funson86 <funson86@gmail.com>
 */
class JqueryUiAsset extends \yii\web\AssetBundle
{
    public $css = [
        'https://cdn.jsdelivr.net/npm/jquery-ui-dist@1.12.0/jquery-ui.min.css',
    ];

    public $js = [
        'https://cdn.jsdelivr.net/npm/jquery-ui-dist@1.12.0/jquery-ui.min.js',
    ];

    public $depends = [
        'common\components\assets\JqueryAsset',
    ];
}