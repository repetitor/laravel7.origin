<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => Str::random(3),
            'email' => 'email.database.seed',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'name' => 'name' . Str::random(2),
            'email' => 'email_' . Str::random(2).'@database.seed',
            'password' => Hash::make('password'),
        ]);
    }
}
