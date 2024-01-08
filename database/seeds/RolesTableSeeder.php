<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [[
            'id'         => 1,
            'title'      => 'Admin',
        ],
            [
                'id'         => 2,
                'title'      => 'Customer',
            ],
            [
                'id'         => 3,
                'title'      => 'Laundry',
            ],
            [
                'id'         => 4,
                'title'      => 'Delivery',
            ]

        ];

        Role::insert($roles);
    }
}
