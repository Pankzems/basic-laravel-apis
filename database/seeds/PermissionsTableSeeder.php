<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [[
            'title'      => 'user_management_access',
        ],
            [
                'title'      => 'permission_create',
            ],
            [
                'title'      => 'permission_edit',
            ],
            [
                'title'      => 'permission_show',
            ],
            [
                'title'      => 'permission_delete',
            ],
            [
                'title'      => 'permission_access',
            ],
            [
                'title'      => 'role_create',
            ],
            [
                'title'      => 'role_edit',
            ],
            [
                'title'      => 'role_show',
            ],
            [
                'title'      => 'role_delete',
            ],
            [
                'title'      => 'role_access',
            ],
            [
                'title'      => 'user_create',
            ],
            [
                'title'      => 'user_edit',
            ],
            [
                'title'      => 'user_show',
            ],
            [
                'title'      => 'user_delete',
            ],
            [
                'title'      => 'user_access',
            ],
            [
                'title'      => 'order_create',
            ],
            [
                'title'      => 'order_delete',
            ],
            [
                'title'      => 'order_accept',
            ],
            [
                'title'      => 'order_reject',
            ],
            [
                'title'      => 'order_cancel',
            ],
            [
                'title'      => 'shop_create',
            ],
            [
                'title'      => 'shop_edit',
            ],
            [
                'title'      => 'shop_show',
            ],
            
        ];

        Permission::insert($permissions);
    }
}
