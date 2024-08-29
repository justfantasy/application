<?php

namespace common\models\admin;

use Yii;
use common\base\Model;

/**
 * This is the model class for table "admin_role_menu".
 *
 * @property int $admin_role_id 角色ID
 * @property int $admin_menu_id 菜单ID
 */
class AdminRoleMenu extends Model
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_role_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['admin_role_id', 'admin_menu_id'], 'required'],
            [['admin_role_id', 'admin_menu_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'admin_role_id' => 'Admin Role ID',
            'admin_menu_id' => 'Admin Menu ID',
        ];
    }

    public static function getMenuIdsByUserId($userId): array
    {
        $roleIds = AdminUserRole::getRoleIdsByUserId($userId);
        if (!$roleIds) {
            return [];
        }

        // 如果是超管，则拥有所有菜单
        if (in_array(Yii::$app->params['adminSuperRoleId'], $roleIds)) {
            return AdminMenu::find()->select(['id'])->asArray()->column();
        }

        return self::find()
            ->select(['admin_menu_id'])
            ->where(['admin_role_id' => $roleIds])
            ->asArray()
            ->column();
    }
}
