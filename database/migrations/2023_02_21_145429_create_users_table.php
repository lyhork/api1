<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        |--------------------------------------------------------------------------
        | Adding foreign key
        |--------------------------------------------------------------------------
        |
        | I am adding a foreign key to type_id field.
        | Here, users_type table id field has biginteger datatype
        |
        |--------------------------------------------------------------------------
        | Values
        |--------------------------------------------------------------------------
        |
        | foreign() – Pass field name which you want to foreign key constraint.
        | references() – Pass linking table field name.
        | on() – Linking table name.
        | onDelete(‘cascade’) – Enable deletion of attached data.
        */
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id', true);

            $table->integer('type_id')->index()->unsigned();
            $table->foreign('type_id')->references('id')->on('users_type')->onDelete('cascade');

            $table->integer('regulator_id')->index()->unsigned();
            $table->foreign('regulator_id')->references('id')->on('regulators')->onDelete('cascade');

            $table->string('name', 50)->nullable();
            $table->string('avatar', 100)->default('static/icon/user.png');
            $table->string('phone', 50)->unique()->nullable();
            $table->string('email', 50)->unique()->nullable();
            $table->string('password');
            $table->dateTime('password_last_updated_at')->nullable();
            $table->dateTime('password_last_updater')->nullable();
            $table->boolean('is_active')->default(0);
            $table->integer('creator_id')->unsigned()->index()->nullable();
            $table->integer('updater_id')->unsigned()->index()->nullable();
            $table->integer('deleter_id')->unsigned()->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
