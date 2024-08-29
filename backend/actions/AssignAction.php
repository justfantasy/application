<?php

namespace backend\actions;

use common\interfaces\AssignModelInterface;
use common\base\Model;
use Yii;
use yii\base\Action;
use yii\web\ServerErrorHttpException;

/**
 * @property Model $modelClass
 * @property String $relationName
 */
class AssignAction extends Action
{
    public $modelClass;
    public $relationName;

    /**
     * @param int $id
     * @return AssignModelInterface
     * @throws ServerErrorHttpException
     */
    public function run(int $id): AssignModelInterface
    {
        $post = Yii::$app->request->post();

        /** @var AssignModelInterface $model */
        $model = new $this->modelClass();
        $model->load($post, '');
        $model->id = $id;
        $model->relation = $this->relationName;

        if (!$model->assign() && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }
}
