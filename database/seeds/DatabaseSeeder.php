<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('users')->insert([
            'admin'    => 1,
            'name'     => 'Admin Demo User',
            'email'    => 'james@test.com',
            'password' => bcrypt('password'),
        ]);
    }
}
