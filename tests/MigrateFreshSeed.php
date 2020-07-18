<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;

trait MigrateFreshSeed
{
    /**
     * If true, setup has run at least once.
     * @var boolean
     */
    protected static $setUpHasRunOnce = false;

    /**
     * After the first run of setUp "migrate:fresh --seed"
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        if (!static::$setUpHasRunOnce) {
            self::refresh();
            static::$setUpHasRunOnce = true;
        }
    }

    static public function refresh()
    {
        Artisan::call('migrate:fresh');
        Artisan::call('passport:install');
        Artisan::call(
            'db:seed', ['--class' => 'DatabaseSeeder']
        );
//            Artisan::call(
//                'db:seed',
//                // ['--class' => 'UsersTableSeeder']
//            );
    }
}
