<?php

use yii\db\Migration;

/**
 * Class m240828_134345_init
 */
// @codingStandardsIgnoreStart
class m240828_134345_init extends Migration
{
    public function safeUp()
    {
        $now = time();

        # 菜单表，表结构
        $this->createTable('{{%admin_users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(50)->notNull()->defaultValue('')->comment('用户名'),
            'password' => $this->string(64)->notNull()->defaultValue('')->comment('密码'),
            'name' => $this->string(50)->notNull()->defaultValue('')->comment('姓名'),
            'avatar' => $this->string(255)->notNull()->defaultValue('')->comment('头像'),
            'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(1)->comment('状态1启用2禁用'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->addCommentOnTable('{{%admin_users}}', '管理员表');
        $this->createIndex('idx_username', '{{%admin_users}}', 'username');
        $this->insert(
            '{{%admin_users}}',
            [
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$13$z6Pc4N5YWHPrx4hg/jj2aORzr4meGeEVsXBnVJ/jzvA/wNtEnny7a', // 123456
                'name' => 'admin',
                'avatar' => 'https://p1-arco.byteimg.com/tos-cn-i-uwbnlip3yd/a8c8cdb109cb051163646151a4a5083b.png~tplv-uwbnlip3yd-webp.webp',
                'created_at' => $now,
                'updated_at' => $now
            ]
        );

        # 菜单表，表结构
        $this->createTable('{{%admin_menus}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('父ID'),
            'weight' => $this->integer()->notNull()->defaultValue(0)->comment('排序权重'),
            'title' => $this->string(50)->notNull()->defaultValue('')->comment('标题'),
            'name' => $this->string(50)->notNull()->defaultValue('')->comment('前端路由别名'),
            'icon' => $this->string(50)->notNull()->defaultValue('')->comment('菜单图标'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('状态1启用2禁用'),
            'created_at' => $this->integer()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->addCommentOnTable('{{%admin_menus}}', '菜单表');
        $this->createIndex('idx_weight', '{{%admin_menus}}', 'weight');
        $this->batchInsert(

            '{{%admin_menus}}',
            ['id', 'parent_id', 'title', 'name', 'icon', 'created_at', 'updated_at'],
            [
                [1, 0, '仪表盘', 'Dashboard', 'icon-dashboard', $now, $now],
                [2, 1, '工作台', 'Workspace', '', $now, $now],
                [3, 0, '系统管理', 'System', 'icon-settings', $now, $now],
                [4, 3, '管理员', 'AdminUserIndex', '', $now, $now],
                [5, 3, '角色', 'AdminRoleIndex', '', $now, $now],
                [6, 3, '菜单', 'AdminMenuIndex', '', $now, $now],
                [7, 3, '日志', 'AdminLogIndex', '', $now, $now],
            ]
        );

        # 角色表，表结构
        $this->createTable('{{%admin_roles}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull()->defaultValue('')->comment('名称'),
            'remark' => $this->string(100)->notNull()->defaultValue('')->comment('备注'),
            'created_at' => $this->integer()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->addCommentOnTable('{{%admin_roles}}', '角色表');
        $this->insert(
            '{{%admin_roles}}',
            [
                'id' => 1,
                'name' => '超级管理员',
                'remark' => '超级管理员角色，不允许修改',
                'created_at' => $now,
                'updated_at' => $now
            ]
        );

        # 权限表，表结构
        $this->createTable('{{%admin_permissions}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->defaultValue('')->comment('名称'),
            'method' => $this->string(10)->notNull()->defaultValue('')->comment('请求方法'),
            'route' => $this->string(128)->notNull()->defaultValue('')->comment('请求路由'),
            'group' => $this->string(60)->notNull()->defaultValue('')->comment('权限组名'),
        ]);

        $this->addCommentOnTable('{{%admin_permissions}}', '权限表');
        $this->batchInsert(
            '{{%admin_permissions}}',
            ['name', 'method', 'route', 'group'],
            [
                ['配置初始化', 'get', 'system/auth/index', '基础功能'],
                ['管理员列表', 'get', 'system/admin-user/index', '系统管理'],
                ['创建管理员', 'post', 'system/admin-user/create', '系统管理'],
                ['修改管理员', 'put', 'system/admin-user/update', '系统管理'],
                ['角色列表', 'get', 'system/admin-role/index', '系统管理'],
                ['创建角色', 'post', 'system/admin-role/create', '系统管理'],
                ['修改角色', 'put', 'system/admin-role/update', '系统管理'],
                ['角色分配菜单', 'post', 'system/admin-role/assign-menu', '系统管理'],
                ['角色分配权限', 'post', 'system/admin-role/assign-permission', '系统管理'],
                ['菜单列表', 'get', 'system/admin-menu/index', '系统管理'],
                ['修改菜单', 'put', 'system/admin-menu/update', '系统管理'],
                ['菜单排序', 'post', 'system/admin-menu/sort', '系统管理'],
                ['权限列表', 'get', 'system/admin-permission/index', '系统管理'],
                ['操作记录列表', 'get', 'system/admin-log/index', '系统管理'],
            ]
        );

        # 用户角色表，表结构
        $this->createTable('{{%admin_user_role}}', [
            'admin_user_id' => $this->integer()->notNull()->defaultValue(0)->comment('管理员ID'),
            'admin_role_id' => $this->integer()->notNull()->defaultValue(0)->comment('角色ID'),
        ]);

        $this->addCommentOnTable('{{%admin_user_role}}', '用户角色表');
        $this->createIndex('idx_admin_user_id', '{{%admin_user_role}}', 'admin_user_id');
        $this->insert(
            '{{%admin_user_role}}',
            [
                'admin_user_id' => 1,
                'admin_role_id' => 1,
            ]
        );

        # 角色菜单表，表结构
        $this->createTable('{{%admin_role_menu}}', [
            'admin_role_id' => $this->integer()->notNull()->defaultValue(0)->comment('角色ID'),
            'admin_menu_id' => $this->integer()->notNull()->defaultValue(0)->comment('菜单ID'),
        ]);

        $this->addCommentOnTable('{{%admin_role_menu}}', '角色菜单表');
        $this->createIndex('idx_admin_role_id', '{{%admin_role_menu}}', 'admin_role_id');

        # 角色权限表，表结构
        $this->createTable('{{%admin_role_permission}}', [
            'admin_role_id' => $this->integer()->notNull()->defaultValue(0)->comment('角色ID'),
            'admin_permission_id' => $this->integer()->notNull()->defaultValue(0)->comment('权限ID'),
        ]);

        $this->addCommentOnTable('{{%admin_role_permission}}', '角色权限表');
        $this->createIndex('idx_admin_role_id', '{{%admin_role_permission}}', 'admin_role_id');

        # 管理员操作日志表
        $this->createTable(
            '{{%admin_logs}}',
            [
                'id' => $this->primaryKey(),
                'method' => $this->string(10)->notNull()->defaultValue('')->comment('请求方法'),
                'route' => $this->string(128)->notNull()->defaultValue('')->comment('请求路由'),
                'ip' => $this->string(60)->notNull()->defaultValue('')->comment('IP地址'),
                'params' => $this->text()->defaultValue(null)->comment('请求参数'),
                'created_by' => $this->integer()->notNull()->defaultValue(0)->comment('新增人id'),
                'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('新增时间'),
            ]
        );

        $this->createIndex('idx_created_at', '{{%admin_logs}}', ['created_at']);
        $this->addCommentOnTable('{{%admin_logs}}', '管理员操作日志表');
    }

    public function safeDown()
    {
        $this->dropTable('{{%admin_users}}');
        $this->dropTable('{{%admin_menus}}');
        $this->dropTable('{{%admin_roles}}');
        $this->dropTable('{{%admin_permissions}}');
        $this->dropTable('{{%admin_user_role}}');
        $this->dropTable('{{%admin_role_menu}}');
        $this->dropTable('{{%admin_role_permission}}');
        $this->dropTable('{{%admin_logs}}');
    }
}
