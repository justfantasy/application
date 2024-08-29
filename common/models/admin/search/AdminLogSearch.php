<?php

namespace common\models\admin\search;

use common\interfaces\SearchModelInterface;
use common\models\admin\AdminLog;
use yii\data\ActiveDataProvider;

/**
 * AdminUserSearch represents the model behind the search form of `common\models\admin\AdminUser`.
 */
class AdminLogSearch extends AdminLog implements SearchModelInterface
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['method', 'route', 'ip'], 'string'],
            [['created_at'], 'safe']
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = self::find()->with(['adminUser']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['method' => $this->method]);
        $query->andFilterWhere(['route' => $this->route]);
        $query->andFilterWhere(['ip' => $this->ip]);

        return $dataProvider;
    }
}
