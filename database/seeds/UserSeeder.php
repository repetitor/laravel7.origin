<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            // insert in phones
            $user->phone()->save(factory(App\Phone::class)->make());

//            // insert in posts
//            $user->posts()->save(factory(App\models\Post::class)->make());

            for ($i = 0; $i < rand(0, 1); $i++) {
                DB::table('descriptions')->insert([
                    'name' => 'description for user ' . $user->id,
                    'descriptionable_id' => $user->id,
                    'descriptionable_type' => 'App\User'
                ]);
            }
        });


    }
}
