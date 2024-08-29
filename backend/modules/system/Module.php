<?php

namespace backend\modules\system;

use Yii;

/**
 * modules module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\system\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // 加载配置来初始化模块
        // Yii::configure($this, require __DIR__ . '/config/main.php');

        // custom initialization code goes here
    }
}
