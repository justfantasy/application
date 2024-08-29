<?php

namespace common\models\admin;

use common\base\Model;
use Yii;

/**
 * This is the model class for table "admin_role_permission".
 *
 * @property int $admin_role_id 角色ID
 * @property int $admin_permission_id 权限ID
 */
class AdminRolePermission extends Model
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'admin_role_permission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['admin_role_id', 'admin_permission_id'], 'required'],
            [['admin_role_id', 'admin_permission_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'admin_role_id' => 'Admin Role ID',
            'admin_permission_id' => 'Admin Permission ID',
        ];
    }

    public static function getPermissionIdsByUserId($userId): array
    {
        $roleIds = AdminUserRole::getRoleIdsByUserId($userId);
        if (!$roleIds) {
            return [];
        }

        // 如果是超管，则拥有所有权限
        if (in_array(Yii::$app->params['adminSuperRoleId'], $roleIds)) {
            return AdminPermission::find()->select(['id'])->asArray()->column();
        }

        return self::find()
            ->select(['admin_permission_id'])
            ->where(['admin_role_id' => $roleIds])
            ->asArray()
            ->column();
    }
}
