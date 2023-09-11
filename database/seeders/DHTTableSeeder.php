<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DHTTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dht_sensor')->insert([
            [
                'moment' => 'now',
                'temperature' => 0.0,
                'humidity' => 0
            ],
        ]);
    }
}
