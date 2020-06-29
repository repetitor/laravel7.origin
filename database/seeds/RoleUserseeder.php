<?php

use App\models\Role;
use App\User;
use Illuminate\Database\Seeder;

class RoleUserseeder extends Seeder
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
                $roles->random(rand(1, 4))->pluck('id')->toArray()
            );
        });
    }
}
