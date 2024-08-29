<?php

namespace common\models\admin\form;

use common\models\admin\AdminUser;
use yii\db\Exception;

/**
 * Login form
 */
class AdminUserForm extends AdminUser
{
    /**
     * 关联角色id
     * @var $role_ids
     */
    public $role_ids;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = [['role_ids'], 'default', 'value' => []];

        return $rules;
    }

    /**
     * @param $insert
     * @param $changedAttributes
     * @return void
     * @throws Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->simpleLinkVia('roles', $this->role_ids, $insert);
        parent::afterSave($insert, $changedAttributes);
    }
}
