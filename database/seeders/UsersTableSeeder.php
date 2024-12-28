<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Shashank Bhattarai',
            'email' => 'mail@shashankbhattarai.com.np',
            'username' => 'shashankb',
            'password' => bcrypt('Shu@#663134')
        ]);
    }
}
