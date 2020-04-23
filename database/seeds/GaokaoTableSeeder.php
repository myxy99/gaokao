<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GaokaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_users')->insert([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'name' => 'Administrator',
        ]);
        DB::table('admin_roles')->insert([
            'name' => 'Administrator',
            'slug' => 'administrator'
        ]);
        DB::table('admin_role_users')->insert([
            'role_id' => 1,
            'user_id' => 1
        ]);
        DB::table('admin_role_permissions')->insert([
            'role_id' => 1,
            'permission_id' => 1
        ]);
        DB::table('admin_permissions')->insert([
            [
                'name' => 'All permission',
                'slug' => '*',
                'http_path' => '*',
            ],
            [
                'name' => 'Dashboard',
                'slug' => 'dashboard',
                'http_method' => 'GET',
                'http_path' => '/',
            ],
            [
                'name' => 'Login',
                'slug' => 'auth.login',
                'http_path' => '/auth/logout',
            ],
            [
                'name' => 'User setting',
                'slug' => 'auth.setting',
                'http_method' => 'GET,PUT',
                'http_path' => '/auth/setting',
            ],
            [
                'name' => 'Auth management',
                'slug' => 'auth.management',
                'http_path' => '/auth/logs',
            ],
            [
                'name' => 'projects',
                'slug' => 'projects',
                'http_path' => '/projects*',
            ],
            [
                'name' => 'school',
                'slug' => 'school',
                'http_path' => '/school*',
            ],
            [
                'name' => 'province',
                'slug' => 'province',
                'http_path' => '/province*',
            ],
            [
                'name' => 'batche',
                'slug' => 'batche',
                'http_path' => '/batche*',
            ],
            [
                'name' => 'school-scoreline',
                'slug' => 'school-scoreline',
                'http_path' => '/school-scoreline*',
            ],
            [
                'name' => 'collage-scoreline',
                'slug' => 'collage-scoreline',
                'http_path' => '/collage-scoreline*',
            ],
            [
                'name' => 'school-recommendations',
                'slug' => 'school-recommendations',
                'http_path' => '/school-recommendations*',
            ],
        ]);
        DB::table('admin_menu')->insert([
            [
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => '仪表盘',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
            ],
            [
                'id' => 2,
                'parent_id' => 0,
                'order' => 9,
                'title' => '系统管理',
                'icon' => 'fa-tasks',
            ],
        ]);
        DB::table('admin_menu')->insert([
            [
                'parent_id' => 2,
                'order' => 11,
                'title' => '用户管理',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
            ],
            [
                'parent_id' => 2,
                'order' => 12,
                'title' => '角色管理',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
            ],
            [
                'parent_id' => 2,
                'order' => 13,
                'title' => '权限管理',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
            ],
            [
                'parent_id' => 2,
                'order' => 14,
                'title' => '菜单管理',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
            ],
            [
                'parent_id' => 2,
                'order' => 15,
                'title' => '日志管理',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
            ],
            [
                'parent_id' => 0,
                'order' => 2,
                'title' => '科类管理',
                'icon' => 'fa-barcode',
                'uri' => 'projects',
            ],
            [
                'parent_id' => 0,
                'order' => 3,
                'title' => '学校管理',
                'icon' => 'fa-bank',
                'uri' => 'schools',
            ],
            [
                'parent_id' => 0,
                'order' => 4,
                'title' => '省份管理',
                'icon' => 'fa-bullseye',
                'uri' => 'provinces',
            ],
            [
                'parent_id' => 0,
                'order' => 5,
                'title' => '批次管理',
                'icon' => 'fa-circle-o-notch',
                'uri' => 'batches',
            ],
            [
                'parent_id' => 0,
                'order' => 6,
                'title' => '学校分数管理',
                'icon' => 'fa-th-large',
                'uri' => 'school-scorelines',
            ],
            [
                'parent_id' => 0,
                'order' => 7,
                'title' => '省份高考分数线管理',
                'icon' => 'fa-connectdevelop',
                'uri' => 'collage-scorelines',
            ],
            [
                'parent_id' => 2,
                'order' => 10,
                'title' => 'Env管理',
                'icon' => 'fa-cog',
                'uri' => 'env-manager',
            ],
            [
                'parent_id' => 0,
                'order' => 8,
                'title' => '学校推荐管理',
                'icon' => 'fa-font-awesome',
                'uri' => 'school-recommendations',
            ],
        ]);
    }
}
