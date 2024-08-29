<?php

/**
 * 微信相关组件类
 */

namespace common\components;

use Yii;
use EasyWeChat\Factory;
use yii\base\BaseObject;
use EasyWeChat\Kernel\ServiceContainer;
use EasyWeChat\OfficialAccount\Application as OfficialAccount;
use EasyWeChat\Payment\Application as Payment;
use EasyWeChat\MiniProgram\Application as MiniProgram;
use EasyWeChat\Work\Application as Work;

/**
 * 主要方便一个微信配置一个单例，不用每次都传入配置参数，若是有新增，请增加对应方法
 *
 * @property OfficialAccount $app 微信公众号实例
 * @property Payment $payment 微信商户号实例
 * @property MiniProgram $miniProgram 微信小程序实例
 * @property Work $work 企业微信实例
 */
class WechatComponent extends BaseObject
{
    /**
     * 静态实例数组
     */
    protected static $instance;

    /**
     * 获取服务号实例
     * @return OfficialAccount
     */
    public function getApp(): OfficialAccount
    {
        return $this->getInstance('wechatConfig', 'officialAccount');
    }

    /**
     * 获取商户号实例
     * @return Payment
     */
    public function getPayment(): Payment
    {
        return $this->getInstance('wechatPaymentConfig', 'payment');
    }

    /**
     * 获取小程序实例
     * @return MiniProgram
     */
    public function getMiniProgram(): MiniProgram
    {
        return $this->getInstance('wechatMiniProgramConfig', 'miniProgram');
    }

    /**
     * 获取企业微信实例
     * @return Work
     */
    public function getWork(): Work
    {
        return $this->getInstance('wechatWorkConfig', 'work');
    }

    /**
     * 若是实例不存在，则根据参数创建一个实例
     * @param $key
     * @param $name
     * @return ServiceContainer|mixed
     */
    protected function getInstance($key, $name)
    {
        self::$instance[$key] = self::$instance[$key] ?? Factory::make($name, Yii::$app->params[$key]);
        return self::$instance[$key];
    }
}
