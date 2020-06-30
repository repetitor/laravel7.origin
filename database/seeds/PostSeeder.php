<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\models\Post::class, 10)->create()->each(function ($post) {
            for ($i = 0; $i < rand(0, 1); $i++) {
                DB::table('descriptions')->insert([
                    'name' => 'description for post ' . $post->id,
                    'descriptionable_id' => $post->id,
                    'descriptionable_type' => 'App\models\Post'
                ]);
            }
        });
    }
}
