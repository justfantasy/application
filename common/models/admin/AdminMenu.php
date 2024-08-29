<?php

namespace common\models\admin;

use common\constants\Constant;
use common\base\Model;
use common\traits\TreeTrait;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "admin_menus".
 *
 * @property int $id
 * @property int $parent_id 父ID
 * @property int $weight 排序权重
 * @property string $title 菜单名
 * @property string $name 路由别名
 * @property string $icon 菜单图标
 * @property int $status 状态0禁用1启用
 * @property int $created_at
 * @property int $updated_at
 */
class AdminMenu extends Model
{
    use TreeTrait;

    public $children;

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'admin_menus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['parent_id', 'weight', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'required'],
            [['title', 'name', 'icon'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'weight' => 'Weight',
            'name' => 'Name',
            'icon' => 'Icon',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function fields()
    {
        return array_merge(parent::fields(), ['children']);
    }

    public function allNodes($status = null, $ids = []): array
    {
        return self::find()
            ->filterWhere(['status' => $status])
            ->andFilterWhere(['in', 'id', $ids])
            ->orderBy(['weight' => SORT_DESC])
            ->all();
    }

    public function updateNode($id, $attributes = [])
    {
        self::updateAll($attributes, ['id' => $id]);
    }

    /**
     * 通过传递的菜单id，获取树状菜单列表
     * @param array $ids
     * @return array
     */
    public static function getMenuTreeByIds(array $ids = []): array
    {
        if (!$ids) {
            return [];
        }

        $self = new self();
        return $self->toTree($self->allNodes(Constant::STATUS_ENABLE, $ids));
    }
}
