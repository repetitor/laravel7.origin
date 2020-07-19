<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTestColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_columns', function (Blueprint $table) {
            $table->string('new_column')
                ->after('will_be_changed')
                ->nullable()
                ->default('default value')
                ->comment('my comment');

            $table->renameColumn('will_be_renamed', 'new_name');

            $table->string('will_be_changed', 50)->nullable()->change();
//            $table->renameColumn('will_be_changed', 'new_name2'); // renaming - good, wait 50 & nullable

            $table->dropColumn('will_be_deleted1');
            $table->dropColumn(['will_be_deleted2', 'will_be_deleted3']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_columns', function (Blueprint $table) {
            $table->dropColumn('new_column');

            $table->renameColumn('new_name', 'will_be_renamed');

            $table->string('will_be_changed', 100)->nullable(false)->change();
//            $table->renameColumn('new_name2', 'will_be_changed');

            $table->char('will_be_deleted1', 100)->nullable();
            $table->char('will_be_deleted2', 100)->nullable();
            $table->char('will_be_deleted3', 100)->nullable();
        });
    }
}
