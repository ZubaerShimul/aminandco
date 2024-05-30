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
            'name'          => "Mr. Admin",
            'email'         => "admin@gmail.com",
            'designation'   => "Admin",
            'is_admin'      => ENABLE,
            'password'      => Hash::make(123456),
            'enable_edit'   => ENABLE,
            'enable_delete' => ENABLE,
        ]);
    }
}
