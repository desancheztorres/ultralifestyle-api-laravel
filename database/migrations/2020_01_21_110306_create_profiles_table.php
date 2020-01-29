<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default('1');
            $table->date('dob');
            $table->integer('height');
            $table->integer('weight');
            $table->enum('gender', ['Male', 'Female']);
            $table->integer('preference_id')->unsigned();
            $table->integer('target_id')->unsigned();
            $table->float('bmi', 3, 1);
            $table->integer('bmr');
            $table->integer('calories');
            $table->integer('calories_used')->default(0);
            $table->integer('carb');
            $table->integer('fat');
            $table->integer('protein');
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('preference_id')->references('id')->on('preferences')->onDelete('cascade');
            $table->foreign('target_id')->references('id')->on('targets')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
