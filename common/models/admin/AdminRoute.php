<?php

namespace common\models\admin;

use common\base\Model;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "admin_routes".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $route 路由地址
 * @property int $status 状态0禁用1启用
 * @property int $created_at
 * @property int $updated_at
 */
class AdminRoute extends Model
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
        return 'admin_routes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'route', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['route'], 'string', 'max' => 255],
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
            'route' => 'Route',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
