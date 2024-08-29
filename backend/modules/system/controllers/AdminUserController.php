<?php

namespace backend\modules\system\controllers;

use common\models\admin\form\AdminUserForm;
use common\models\admin\search\AdminUserSearch;
use backend\controllers\Controller;

/**
 * AdminUserController implements the CRUD actions for AdminUser model.
 */
class AdminUserController extends Controller
{
    public $modelClass = AdminUserForm::class;

    public function actions(): array
    {
        return [
            'index' => [
                'class' => 'backend\actions\IndexAction',
                'modelClass' => AdminUserSearch::class,
            ],
            'create' => [
                'class' => 'yii\rest\CreateAction',
                'modelClass' => $this->modelClass,
            ],
            'update' => [
                'class' => 'yii\rest\UpdateAction',
                'modelClass' => $this->modelClass,
            ],
        ];
    }
}
