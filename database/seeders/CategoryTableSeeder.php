<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert(array(

            [
                'name'  => "Opening Balance",
                'type'  => CATEGORY_TYPE_INCOME,
                'read_only' => ENABLE
            ],            [
                'name'  => "Official Expense",
                'type'  => CATEGORY_TYPE_EXPENSE,
                'read_only' => ENABLE
            ],
            [
                'name'  => "Labour Salary",
                'type'  => EXPENSE,
                'read_only' => ENABLE
            ],
            [
                'name'  => "Payment Received",
                'type'  => CATEGORY_TYPE_INCOME,
                'read_only' => ENABLE
            ],
            [
                'name'  => "Bank Transfer",
                'type'  => CATEGORY_TYPE_INCOME,
                'read_only' => ENABLE
            ],
            [
                'name'  => "Bank Transfer",
                'type'  => EXPENSE,
                'read_only' => ENABLE
            ],

        ));
    }
}
