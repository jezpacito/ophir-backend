<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::create([
            'branch_number' => rand(0, 99999),
            'name' => 'General Santos City Branch',
            'address' => 'General Santos City',
        ]);
    }
}
