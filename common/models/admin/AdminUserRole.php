<?php

namespace common\models\admin;

use common\base\Model;
use Yii;

/**
 * This is the model class for table "admin_user_role".
 *
 * @property int $admin_user_id 管理员ID
 * @property int $admin_role_id 角色ID
 */
class AdminUserRole extends Model
{
    public static $userRoles;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'admin_user_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['admin_user_id', 'admin_role_id'], 'required'],
            [['admin_user_id', 'admin_role_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'admin_user_id' => 'Admin User ID',
            'admin_role_id' => 'Admin Role ID',
        ];
    }

    public static function getRoleIdsByUserId($userId)
    {
        if (!$userId) {
            return [];
        }

        if (isset(self::$userRoles[$userId])) {
            return self::$userRoles[$userId];
        }

        return self::$userRoles[$userId] = self::find()
            ->where(['admin_user_id' => $userId])
            ->select(['admin_role_id'])
            ->asArray()
            ->column();
    }
}
