<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
          'name'      => "Admin",
          'email'     => "admin@admin.com",
          'password'  => Hash::make("admin123"),
        ]);
    }
}
