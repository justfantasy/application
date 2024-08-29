<?php

namespace common\interfaces;

use yii\data\ActiveDataProvider;

interface SearchModelInterface
{
    public function search(array $params): ActiveDataProvider;
}
