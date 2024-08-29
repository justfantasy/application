<?php

namespace backend\actions;

use Yii;
use common\interfaces\SearchModelInterface;
use yii\data\ActiveDataProvider;
use yii\base\Action;

class IndexAction extends Action
{
    /**
     * @var SearchModelInterface
     */
    public $modelClass;

    /**
     * @return ActiveDataProvider
     */
    public function run(): ActiveDataProvider
    {
        /** @var SearchModelInterface $searchModel */
        $searchModel = new $this->modelClass();
        return $searchModel->search(Yii::$app->request->queryParams);
    }
}
