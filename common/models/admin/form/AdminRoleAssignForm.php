<?php

namespace common\models\admin\form;

use common\interfaces\AssignModelInterface;
use common\models\admin\AdminRole;
use common\base\Model;
use yii\db\Exception;

/**
 * @property AdminRole|null $adminRole
 * Login form
 */
class AdminRoleAssignForm extends Model implements AssignModelInterface
{
    public $data;
    public $relation;
    public $id;
    private $adminRole;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['data', 'relation', 'id'], 'required'],
            [['id'], 'integer'],
            [['relation'], 'string'],
            [['id'], 'validateId']
        ];
    }

    public function validateId($attribute)
    {
        if (!$this->hasErrors()) {
            $this->adminRole = AdminRole::findOne($this->id);
            if (!$this->adminRole) {
                $this->addError($attribute, '角色不存在，请检查！');
            }
        }
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function assign(): bool
    {
        if ($this->validate()) {
            $this->adminRole->simpleLinkVia($this->relation, $this->data, false);
            return true;
        }

        return false;
    }
}
