<?php

namespace backend\modules\system\controllers;

use common\models\admin\AdminRole;
use common\models\admin\form\AdminRoleAssignForm;
use common\models\admin\search\AdminRoleSearch;
use backend\controllers\Controller;

class AdminRoleController extends Controller
{
    public $modelClass = AdminRole::class;

    protected $assignModelClass = AdminRoleAssignForm::class;

    public function actions(): array
    {
        return [
            'index' => [
                'class' => 'backend\actions\IndexAction',
                'modelClass' => AdminRoleSearch::class,
            ],
            'create' => [
                'class' => 'yii\rest\CreateAction',
                'modelClass' => $this->modelClass,
            ],
            'update' => [
                'class' => 'yii\rest\UpdateAction',
                'modelClass' => $this->modelClass,
            ],
            'assign-menu' => [
                'class' => 'backend\actions\AssignAction',
                'modelClass' => $this->assignModelClass,
                'relationName' => 'menus'
            ],
            'assign-permission' => [
                'class' => 'backend\actions\AssignAction',
                'modelClass' => $this->assignModelClass,
                'relationName' => 'permissions'
            ]
        ];
    }
}
