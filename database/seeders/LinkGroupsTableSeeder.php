<?php

namespace Database\Seeders;

use App\Models\LinkGroup;
use Illuminate\Database\Seeder;

class LinkGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LinkGroup::create([
            'group_name' => 'Ludicene Cream',
            'user_id' => 1,
        ]);
    }
}
