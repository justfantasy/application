<?php

namespace common\models\admin;

use common\base\Model;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "admin_roles".
 *
 * @property int $id
 * @property string $name 名称
 * @property int $created_at
 * @property int $updated_at
 */
class AdminRole extends Model
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
        return 'admin_roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 100],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
//
//    public function fields()
//    {
//        $fields = parent::fields();
//        $fields['test'] = function (AdminRole $model) {
//            return $model->id . '|||' . $model->name;
//        };
//        return $fields;
//    }

    /**
     * 获取角色菜单
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getMenus(): ActiveQuery
    {
        return $this->hasMany(AdminMenu::class, ['id' => 'admin_menu_id'])
            ->viaTable('admin_role_menu', ['admin_role_id' => 'id']);
    }

    /**
     * 获取角色权限
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getPermissions(): ActiveQuery
    {
        return $this->hasMany(AdminPermission::class, ['id' => 'admin_permission_id'])
            ->viaTable('admin_role_permission', ['admin_role_id' => 'id']);
    }
}
