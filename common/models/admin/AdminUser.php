<?php

namespace common\models\admin;

use Yii;
use common\constants\Constant;
use common\behaviors\PasswordBehavior;
use common\base\Model;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin_users".
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $name 姓名
 * @property string $avatar 头像
 * @property int $status 状态0禁用1启用
 * @property int $created_at
 * @property int $updated_at
 */
class AdminUser extends Model implements IdentityInterface
{
    /**
     * 绑定相关行为
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            PasswordBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'admin_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username', 'password', 'name'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['username', 'name'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 64],
            [['avatar'], 'string', 'max' => 255],
            [['username'], 'unique', 'message' => '用户名已存在。']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Real Name',
            'avatar' => 'Avatar',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * 重构，去掉敏感字段
     * @return array|int[]|string[]
     */
//    public function fields(): array
//    {
//        $fields = parent::fields();
//        unset($fields['password']);
//        return $fields;
//    }

    /**
     * 通过用户名获取用户信息
     * @param $username
     * @return AdminUser|null
     */
    public static function findByUsername($username): ?AdminUser
    {
        return static::findOne(['username' => $username, 'status' => Constant::STATUS_ENABLE]);
    }

    /**
     * 校验密码是否正确
     * @param $password
     * @return bool
     */
    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public static function findIdentity($id)
    {
    }

    /**
     * jwt方式仅需要实现此方法即可
     * @param $token
     * @param $type
     * @return AdminUser|IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne([
            'id' => intval($token->getClaim('user_id')),
            'status' => Constant::STATUS_ENABLE
        ]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey(): ?string
    {
        return '';
    }

    public function validateAuthKey($authKey): ?bool
    {
        return true;
    }

    /**
     * 获取用户角色
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getRoles(): ActiveQuery
    {
        return $this->hasMany(AdminRole::class, ['id' => 'admin_role_id'])
            ->viaTable('admin_user_role', ['admin_user_id' => 'id']);
    }
}
