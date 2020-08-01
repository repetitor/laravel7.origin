<?php

use App\Author;
use App\Category;
use App\News;
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

        factory(Author::class, 5)->create();

//        factory(Category::class, 5)->create();
        factory(Category::class)->create(['name' => 'Главные']);
        factory(Category::class)->create(['name' => 'Политика']);
        factory(Category::class)->create(['name' => 'Экономика']);

        factory(News::class, 25)->create();
    }
}
