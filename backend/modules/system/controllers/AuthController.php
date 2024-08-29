<?php

namespace backend\modules\system\controllers;

use common\models\admin\AdminMenu;
use common\models\admin\AdminPermission;
use Yii;
use common\models\admin\AdminRoleMenu;
use common\models\admin\AdminRolePermission;
use common\traits\JwtTrait;
use common\models\admin\form\LoginForm;
use backend\controllers\Controller;

class AuthController extends Controller
{
    use JwtTrait;

    /**
     * 完成用户登录
     * @return array|LoginForm
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $post = $this->request->post();

        if ($model->load($post, '') && $model->login()) {
            return $this->getUserData();
        }

        return $model;
    }

    /**
     * 刷新token，保持token的活跃
     * @return array
     */
    public function actionIndex(): array
    {
        return $this->getUserData();
    }

    /**
     * 构造返回数据
     * @return array
     */
    protected function getUserData(): array
    {
        $userId = Yii::$app->user->id;
        return [
            'user' => Yii::$app->user->identity,
            'token' => $this->createJwt($userId),
            'menus' => AdminMenu::getMenuTreeByIds(AdminRoleMenu::getMenuIdsByUserId($userId)),
            'permissions' => AdminPermission::getRoutesByIds(AdminRolePermission::getPermissionIdsByUserId($userId)),
        ];
    }
}
