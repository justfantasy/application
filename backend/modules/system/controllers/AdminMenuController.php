<?php

namespace backend\modules\system\controllers;

use common\models\admin\AdminMenu;
use backend\controllers\Controller;
use common\models\admin\form\AdminMenuSortForm;
use Yii;
use yii\web\ServerErrorHttpException;

class AdminMenuController extends Controller
{
    public $modelClass = AdminMenu::class;

    public function actions(): array
    {
        return [
            'update' => [
                'class' => 'yii\rest\UpdateAction',
                'modelClass' => $this->modelClass,
            ],
        ];
    }

    public function actionIndex(): array
    {
        /** @var AdminMenu $model */
        $model = new $this->modelClass();
        return $model->toTree($model->allNodes());
    }

    /**
     * 更新排序和父子级关系
     * @throws ServerErrorHttpException
     */
    public function actionSort(): AdminMenuSortForm
    {
        $post = Yii::$app->request->post();
        $model = new AdminMenuSortForm();
        $model->load($post, '');

        if ($model->sort() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model;
    }
}
