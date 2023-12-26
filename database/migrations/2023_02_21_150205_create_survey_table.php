<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey', function (Blueprint $table) {
            $table->increments('id', true);
            $table->integer('regulator_id')->index()->unsigned();
            $table->foreign('regulator_id')->references('id')->on('regulators')->onDelete('cascade');
            $table->integer('type_id')->index()->unsigned();
            $table->foreign('type_id')->references('id')->on('survey_type')->onDelete('cascade');
            $table->string('value', 250)->default('');
            $table->string('comment', 250)->default('');
            $table->string('description', 150)->default('');
            $table->dateTime('date_at')->nullable();
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
        Schema::dropIfExists('survey');
    }
}
