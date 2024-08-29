<?php

namespace common\traits;

use Yii;
use common\constants\Constant;

trait JwtTrait
{
    /**
     * token生成方法
     * @param $userId
     * @return string
     */
    public function createJwt($userId): string
    {
        $jwt = Yii::$app->jwt;
        $time = time();
        return $jwt->getBuilder()
            ->issuedAt($time) // Configures the time that the token was issue (iat claim)
            ->expiresAt($time + Constant::JWT_EXPIRE_TIME) // Configures the expiration time of the token (exp claim)
            ->withClaim('user_id', $userId) // Configures a new claim, called "uid"
            ->getToken($jwt->getSigner('HS256'), $jwt->getKey());
    }
}
