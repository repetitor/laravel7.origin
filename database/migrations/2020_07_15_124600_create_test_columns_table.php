<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_columns', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_uuid')->nullable();
            $table->ipAddress('visitor')->nullable();
            $table->macAddress('device')->nullable();
            $table->rememberToken()->nullable();

            $table->foreignId('user_id')->nullable();
            $table->morphs('taggable'); // can't be null
            $table->uuidMorphs('taggable_char'); // can't be null
//             $table->nullableMorphs('taggable_nullable'); // long index
//            // =>
            $table->nullableMorphs('taggable_null');
//            // wait
//            $table->nullableMorphs('taggable_nullable')
//                ->unique(['taggable_nullable_type', 'taggable_nullable_id'], 'unique_taggable_nullable_index');
//            $table->nullableMorphs('taggable_nullable')
//                ->index(['taggable_nullable_type', 'taggable_nullable_id'], 'unique_index');

            $table->binary('data')->nullable();
            $table->boolean('confirmed')->nullable();
//            $table->enum('level_enum', ['easy', 'hard'])->nullable();
//            $table->set('flavors_set', ['strawberry', 'vanilla'])->nullable();
            $table->json('options')->nullable();
            $table->jsonb('options_jsonb')->nullable();

            $table->bigInteger('votes')->nullable();
            $table->integer('votes_integer')->nullable();
            $table->mediumInteger('votes_medium')->nullable();
            $table->decimal('amount_decimal', 8, 2)->nullable();
            $table->double('amount_double', 8, 2)->nullable();
            $table->float('amount_float', 8, 2)->nullable();

            $table->char('name_char', 100)->nullable();
            $table->string('name_varchar', 100)->nullable();
            $table->text('description')->nullable();
            $table->longText('description_long')->nullable();

            // it is good but on start next migration =>
            // Unknown database type geomcollection requested,
            // Doctrine\DBAL\Platforms\MySQL80Platform may not support it..
//            $table->geometryCollection('positions')->nullable();
//            $table->geometry('positions_geometry')->nullable();
//            $table->lineString('positions_line')->nullable();
//            $table->multiLineString('positions_multiline')->nullable();
//            $table->multiPoint('positions_multipoint')->nullable();
//            $table->multiPolygon('positions_multipolygon')->nullable();

            $table->date('date')->nullable();
            $table->dateTime('datetime', 0)->nullable();
            $table->dateTimeTz('date_time_tz', 0)->nullable();
            $table->time('sunrise', 0)->nullable();
            $table->year('birth_year')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);

            $table->char('will_be_renamed', 100)->nullable();
            $table->char('will_be_changed', 100);
            $table->char('will_be_deleted1', 100)->nullable();
            $table->char('will_be_deleted2', 100)->nullable();
            $table->char('will_be_deleted3', 100)->nullable();

            $table->index(['name_char', 'name_varchar'], 'nullable_index');
            $table->index(['name_char', 'name_varchar'], 'unique_nullable_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_columns');
    }
}
