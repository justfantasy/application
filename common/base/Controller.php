<?php

namespace common\base;

use yii\rest\Controller as BaseController;
use yii\web\NotFoundHttpException;
use yii\web\Request;

/**
 * @property Model $modelClass
 * @property Request $request
 */
class Controller extends BaseController
{
    public $modelClass = null;

    /**
     * Declares the allowed HTTP verbs. Please refer to [[VerbFilter::actions]] on how to declare the allowed verbs.
     * @return array[]
     */
    protected function verbs(): array
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        $model = $modelClass ? $modelClass::findOne($id) : null;

        if ($model) {
            return $model;
        }

        throw new NotFoundHttpException("Object not found: $id");
    }
}
