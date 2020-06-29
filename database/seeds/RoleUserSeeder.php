<?php

use App\models\Role;
use App\User;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::get();
        $users = User::get();

        $users->each(function ($user) use ($roles)
        {
            $user->roles()->attach(
                $roles->random(rand(0, 3))->pluck('id')->toArray()
            );
        });
    }
}
