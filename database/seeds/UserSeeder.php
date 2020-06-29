<?php

use Illuminate\Database\Seeder;

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

//        factory(App\User::class, 5)->create();

        factory(App\User::class, 5)->create()->each(function ($user) {
            $user->phone()->save(factory(App\Phone::class)->make());
        });


    }
}
