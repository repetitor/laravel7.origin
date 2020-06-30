<?php

use App\models\Post;
use App\models\Tag;
use App\User;
use Illuminate\Database\Seeder;

class TaggableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::get();
        $users = User::get();
        $posts = Post::get();

        $users->each(function ($user) use ($tags)
        {
            $user->tags()->attach(
//                $tags->random(rand(0, count($tags)))->pluck('id')->toArray()
//                $tags->random(rand(0, count($tags)))->pluck('id')
//                $tags->random(rand(0, count($tags)))
                $tags->random(rand(0, 2))
            );
        });

        $posts->each(function ($post) use ($tags)
        {
            $post->tags()->attach(
                $tags->random(rand(1, count($tags)))
            );
        });
    }
}
