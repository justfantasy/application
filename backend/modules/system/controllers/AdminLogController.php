<?php

namespace backend\modules\system\controllers;

use common\models\admin\AdminLog;
use common\models\admin\search\AdminLogSearch;
use backend\controllers\Controller;

class AdminLogController extends Controller
{
    public $modelClass = AdminLog::class;

    public function actions(): array
    {
        return [
            'index' => [
                'class' => 'backend\actions\IndexAction',
                'modelClass' => AdminLogSearch::class,
            ],
        ];
    }
}
