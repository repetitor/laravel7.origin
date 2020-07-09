<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriberIdToUsers extends Migration
{
    protected $tableManipulate = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('subscriber_id')->after('name')->nullable();
        });

        $users = \App\User::get();

        foreach($users as $user){
            $user->update(['subscriber_id' => 100000 + $user->id]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('subscriber_id');
        });
    }
}
