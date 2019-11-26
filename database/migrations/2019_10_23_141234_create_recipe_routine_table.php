<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipeRoutineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_routine', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('routine_id')->unsigned();
            $table->integer('recipe_id')->unsigned();
            $table->integer('week_day_id')->unsigned();
            $table->timestamps();

            $table->foreign('routine_id')->references('id')->on('routines')->onDelete('cascade');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
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
        Schema::dropIfExists('recipe_routine');
    }
}
