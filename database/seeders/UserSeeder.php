<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create a single test user
        User::create([
            'name' => 'Super admin',
            'email' => 'admin@admin.com',
            'phone'=>'1234567890',
            'password' => '123456', // Hashing the password
        ]);

        // You can create multiple test users using the User::factory() method if you have defined a factory
        // User::factory()->count(35)->create();
    }
}
