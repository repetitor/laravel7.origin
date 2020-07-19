<?php

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

//        DB::table('users')->insert([
//            'name' => Str::random(10),
//            'email' => 'email.database.seed',
//            'password' => Hash::make('password'),
//        ]);
//
//        DB::table('users')->insert([
//            'name' => 'name' . Str::random(4),
//            'email' => 'email_' . Str::random(2).'@database.seed',
//            'password' => Hash::make('password'),
//        ]);

            $this->call([
                OrderSeeder::class,
//                UserSeeder::class,
//                PostSeeder::class,
//                CommentSeeder::class,
//                RoleSeeder::class,
//                RoleUserSeeder::class,
////            DescriptionSeeder::class,
//                TagSeeder::class,
//                TaggableSeeder::class,
            ]);
    }
}
