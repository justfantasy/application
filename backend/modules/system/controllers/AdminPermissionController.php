<?php

namespace backend\modules\system\controllers;

use common\models\admin\AdminPermission;
use backend\controllers\Controller;

class AdminPermissionController extends Controller
{
    public function actionIndex(): array
    {
        return AdminPermission::getAllByGroupKey();
    }
}
