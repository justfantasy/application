<?php

/**
 * 常量类方法，不同特性的常量类需新建对应的常量类，例如：cache. session等等
 */

namespace common\constants;

class Constant
{
    /**
     * jwt过期时间为10天
     */
    public const JWT_EXPIRE_TIME = 10 * 24 * 60 * 60;

    /**
     * 启用状态
     */
    public const STATUS_ENABLE = 1;

    /**
     * 禁用状态
     */
    public const STATUS_DISABLE = 2;
}
