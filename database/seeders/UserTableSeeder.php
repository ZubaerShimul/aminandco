<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => "Mr. Admin",
            'email' => "admin@gmail.com",
            'is_admin' => ENABLE,
            'password' => Hash::make(123456)
        ]);

        User::create([
            'name' => "Mr. User",
            'email' => "user@gmail.com",
            'password' => Hash::make(123456)
        ]);
    }
}
