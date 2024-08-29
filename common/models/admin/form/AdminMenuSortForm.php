<?php

namespace common\models\admin\form;

use common\models\admin\AdminMenu;
use common\base\Model;

/**
 * Login form
 */
class AdminMenuSortForm extends Model
{
    public $menus;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['menus'], 'required', 'message' => '参数错误！'],
        ];
    }

    public function sort(): bool
    {
        if ($this->validate()) {
            (new AdminMenu())->updateNodes($this->menus);
            return true;
        }

        return false;
    }
}
