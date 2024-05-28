<?php

namespace Database\Seeders;

use App\Models\AccountHistory;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountHisotoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AccountHistory::create([
            'date'      => Carbon::now()->toDateString(),
            'opening'   => 0,
            'closing'   => 0
        ]);
    }
}
