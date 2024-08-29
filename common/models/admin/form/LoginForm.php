<?php

namespace common\models\admin\form;

use Yii;
use common\models\admin\AdminUser;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    protected $user;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * 校验密码规则
     * @param string $attribute the attribute currently being validated
     */
    public function validatePassword(string $attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码错误！');
            }
        }
    }

    /**
     * 完成用户登录
     * @return bool whether the user is logged in successfully
     */
    public function login(): bool
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        }

        return false;
    }

    /**
     * 获取用户
     * @return AdminUser|null
     */
    protected function getUser(): ?AdminUser
    {
        if ($this->user === null) {
            $this->user = AdminUser::findByUsername($this->username);
        }

        return $this->user;
    }
}
