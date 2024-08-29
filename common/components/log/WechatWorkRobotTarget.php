<?php

namespace common\components\log;

use Yii;
use yii\log\Target;
use yii\log\LogRuntimeException;

class WechatWorkRobotTarget extends Target
{
    /**
     * @var string 企业微信机器人key
     */
    public $robotKey;

    /**
     * @return void
     * @throws LogRuntimeException
     */
    public function export()
    {
        $text = implode("\n", array_map([$this, 'formatMessage'], $this->messages));

        try {
            Yii::$app->wechat->work
                ->group_robot_messenger
                ->toGroup($this->robotKey)
                ->send($text);
        } catch (\Exception $e) {
            throw new LogRuntimeException('无法将错误日志发送到企业微信机器人');
        }
    }
}
