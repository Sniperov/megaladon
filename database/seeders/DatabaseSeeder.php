<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        (new CitySeeder())->run();
        // User::create([
        //     'name' => 'Sniperov',
        //     'phone' => '+77479400950',
        //     'city_id' => 1,
        //     'password' => Hash::make('123321'),
        //     'email' => 'snaiperov60@gmail.com',
        //     'role' => 'admin',
        // ]);
    }
}
