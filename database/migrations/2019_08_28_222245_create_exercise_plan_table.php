<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExercisePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_plan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_id')->unsigned()->index();
            $table->integer('exercise_id')->unsigned()->index();
            $table->integer('sets')->unsigned()->nullable();
            $table->integer('reps')->unsigned()->nullable();
            $table->integer('week_day_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
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
        Schema::dropIfExists('exercise_plan');
    }
}
