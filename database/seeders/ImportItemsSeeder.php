<?php

namespace Database\Seeders;

use App\Models\ImportItem;
use Illuminate\Database\Seeder;

class ImportItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ImportItem::create([
            'network' => 'clickbank',
            'data' => 'this is the test data type',
            'data_type' => 0
        ]);
    }
}
