<?php

namespace common\behaviors;

use Yii;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

/**
 * 用于密码字段的自动加密
 * @property ActiveRecord $owner
 */
class PasswordBehavior extends AttributeBehavior
{
    /**
     * @var string 密码字段的字段名称
     */
    public $passwordAttribute = 'password';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->passwordAttribute,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->passwordAttribute,
            ];
        }
    }

    /**
     * @param $event
     * @return array|mixed|string
     * @throws Exception
     */
    protected function getValue($event)
    {
        $value = $this->owner->{$this->passwordAttribute};
        if ($this->owner->isNewRecord || $value != $this->owner->oldAttributes[$this->passwordAttribute]) {
            return Yii::$app->security->generatePasswordHash($value);
        }

        return $value;
    }
}
