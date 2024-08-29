<?php

namespace common\models\admin;

use common\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "admin_permissions".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $method 请求方法
 * @property string $route 请求路由
 * @property string $group 权限组名
 * @property int $created_at
 * @property int $updated_at
 */
class AdminPermission extends Model
{
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
        return 'admin_permissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'method', 'route', 'group', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['method'], 'string', 'max' => 10],
            [['route'], 'string', 'max' => 128],
            [['group'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'method' => 'Method',
            'route' => 'Route',
            'group' => 'Group',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getIdByRouteAndMethod($route, $method): int
    {
        return static::find()
            ->select(['id'])
            ->where(['route' => $route, 'method' => $method])
            ->asArray()
            ->scalar();
    }

    public static function getRoutesByIds($ids): array
    {
        if (!$ids) {
            return [];
        }

        return static::find()
            ->select(['route'])
            ->where(['id' => $ids])
            ->asArray()
            ->column();
    }

    public static function getAllByGroupKey(): array
    {
        $data = static::find()
            ->select(['id', 'name', 'group'])
            ->asArray()
            ->all();

        return ArrayHelper::index($data, null, 'group');
    }
}
