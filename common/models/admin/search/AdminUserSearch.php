<?php

namespace common\models\admin\search;

use common\interfaces\SearchModelInterface;
use yii\data\ActiveDataProvider;
use common\models\admin\AdminUser;

/**
 * AdminUserSearch represents the model behind the search form of `common\models\admin\AdminUser`.
 */
class AdminUserSearch extends AdminUser implements SearchModelInterface
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['username', 'name'], 'string'],
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
        $query = self::find()->with('roles');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
