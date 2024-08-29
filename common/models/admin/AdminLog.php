<?php

namespace common\models\admin;

use Yii;
use common\base\Model;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "admin_operation_logs".
 *
 * @property int $id
 * @property string $method 请求方法
 * @property string $route 请求路由
 * @property string $ip IP地址
 * @property string|null $params 请求参数
 * @property int $created_by 新增人id
 * @property int $created_at 新增时间
 */
class AdminLog extends Model
{
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'admin_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['params'], 'string'],
            [['created_by', 'created_at'], 'integer'],
            [['method'], 'string', 'max' => 10],
            [['route'], 'string', 'max' => 128],
            [['ip'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'method' => 'Method',
            'route' => 'Route',
            'ip' => 'Ip',
            'params' => 'Params',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }

    /**
     * 关联操作用户信息
     * @return ActiveQuery
     */
    public function getAdminUser(): ActiveQuery
    {
        return $this->hasOne(AdminUser::class, ['id' => 'created_by'])->select(['id', 'name']);
    }

    /**
     * 保存一条新的日志记录
     * @param $attributes
     * @return void
     */
    public static function create($attributes)
    {
        $model = new self();
        $model->attributes = $attributes;

        if (!$model->save()) {
            Yii::error('管理端保存请求日志失败');
            Yii::error($model->errors);
        }
    }
}
