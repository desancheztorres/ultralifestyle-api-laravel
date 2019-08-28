<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodyPartExerciseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('body_part_exercise', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('body_part_id')->unsigned()->index();
            $table->integer('exercise_id')->unsigned()->index();

            $table->foreign('body_part_id')->references('id')->on('body_parts')->onDelete('cascade');
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('body_part_exercise');
    }
}
