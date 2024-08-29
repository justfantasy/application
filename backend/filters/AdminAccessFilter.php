<?php

namespace backend\filters;

use Yii;
use common\models\admin\AdminLog;
use common\models\admin\AdminPermission;
use common\models\admin\AdminRolePermission;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

/**
 * 引入该行为将检测该用户是否有请求路由的权限
 */
class AdminAccessFilter extends ActionFilter
{
    /**
     * @throws ForbiddenHttpException
     */
    public function beforeAction($action): bool
    {
        $route = $action->controller->module->id . '/' . $action->controller->id . '/' . $action->id;
        if (in_array($route, $this->except)) {
            return parent::beforeAction($action);
        }

        if (!Yii::$app->user->id) {
            throw new ForbiddenHttpException('未登录用户无权访问');
        }

        $method = strtolower(Yii::$app->request->method);

        // 获取该路由的权限id
        $permissionId = AdminPermission::getIdByRouteAndMethod($route, $method);
        if (!$permissionId) {
            throw new ForbiddenHttpException('未添加该路由权限，请检查');
        }

        $rolePermissionIds = AdminRolePermission::getPermissionIdsByUserId(Yii::$app->user->id);
        if (!in_array($permissionId, $rolePermissionIds)) {
            throw new ForbiddenHttpException('无权访问该路由');
        }

        // 记录访问日志
        $input = json_encode(array_merge(Yii::$app->request->get(), Yii::$app->request->post()));
        AdminLog::create([
            'method' => $method,
            'route' => Yii::$app->request->pathInfo,
            'ip' => Yii::$app->request->userIP,
            'params' => strlen($input) > 65000 ? '' : $input,
        ]);

        return parent::beforeAction($action);
    }
}
