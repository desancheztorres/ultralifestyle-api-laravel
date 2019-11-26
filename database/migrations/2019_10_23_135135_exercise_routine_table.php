<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExerciseRoutineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_routine', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('routine_id')->unsigned();
            $table->integer('exercise_id')->unsigned();
            $table->integer('sets')->unsigned()->default(0);
            $table->integer('reps')->unsigned()->default(0);
            $table->integer('week_day_id')->unsigned();
            $table->timestamps();

            $table->foreign('routine_id')->references('id')->on('plans')->onDelete('cascade');
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
            $table->foreign('week_day_id')->references('id')->on('week_days')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_routine');
    }
}
