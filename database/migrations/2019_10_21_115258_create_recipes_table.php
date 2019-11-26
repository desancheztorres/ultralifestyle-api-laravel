<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('image');
            $table->integer('category_id')->unsigned();
            $table->text('ingredients');
            $table->text('instructions');
            $table->integer('prep');
            $table->integer('cook');
            $table->integer('ready_in');
            $table->integer('calories');
            $table->float('protein');
            $table->float('carb');
            $table->float('fat');
            $table->string('author');
            $table->string('link');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('recipe_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
