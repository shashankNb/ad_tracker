<?php

namespace Database\Seeders;

use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LinkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Link::insert([
            [
                'link_name' => 'Ludicene LP',
                'tracking_link_id' => 1,
                'tracking_slug' => 'try-ludicene',
                'primary_url' => 'http://landingpage.local?s1=[clickid]',
                'group_id' => 1,
                'network_id' => 2,
                'is_action' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'link_name' => 'Ludicene Sales Page',
                'tracking_link_id' => 1,
                'tracking_slug' => 'sales-page',
                'primary_url' => 'http://www.google.com?s2=[s1]',
                'group_id' => 1,
                'network_id' => 2,
                'is_action' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
