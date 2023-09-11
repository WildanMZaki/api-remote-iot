<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PinsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed the "pins" table with initial data
        DB::table('pins')->insert([
            ['pin' => 'pin12', 'state' => 0, 'number' => 12],
            ['pin' => 'pin13', 'state' => 0, 'number' => 13],
            ['pin' => 'pin14', 'state' => 0, 'number' => 14],
        ]);
    }
}