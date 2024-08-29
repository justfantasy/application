<?php

namespace common\models\admin\search;

use common\interfaces\SearchModelInterface;
use common\models\admin\AdminRole;
use yii\data\ActiveDataProvider;

/**
 * AdminUserSearch represents the model behind the search form of `common\models\admin\AdminUser`.
 */
class AdminRoleSearch extends AdminRole implements SearchModelInterface
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string'],
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
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
