<?php

namespace Database\Seeders;

use App\Models\TrackingLink;
use Illuminate\Database\Seeder;

class TrackingLinkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TrackingLink::create([
            'link' => 'http://track.trackmagic.local'
        ]);
    }
}
