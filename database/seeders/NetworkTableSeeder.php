<?php

namespace Database\Seeders;

use App\Models\Network;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class NetworkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Network::insert([
            [
                'network_name' => 'Max Bounty',
                'network_code' => 'maxbounty',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'network_name' => 'Click Bank',
                'network_code' => 'clickbank',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
