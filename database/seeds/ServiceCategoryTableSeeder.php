<?php

use Illuminate\Database\Seeder;
use App\ServiceCategory;

class ServiceCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [[
            'id'         => 1,
            'name'      => 'Wash & Fold',
        ],
            [
                'id'         => 2,
                'name'      => 'Wash & Iron',
            ],
            [
                'id'         => 3,
                'name'      => 'Premium Laundry',
            ],
            [
                'id'         => 4,
                'name'      => 'Dry Clean',
            ]

        ];

        ServiceCategory::insert($categories);
    }
}
