<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planners', function (Blueprint $table) {
            $table->id('plannerID');
            $table->String('name');
            $table->String('location');
            $table->date('dob');
            $table->String('password');
            $table->tinyinteger('rate');
            $table->String('profileIMG')->nullable();
            $table->String('image1')->nullable();
            $table->String('image2')->nullable();
            $table->String('image3')->nullable();
            $table->String('image4')->nullable();
            $table->String('image5')->nullable();
            $table->String('contact');
            $table->String('email');
            $table->longtext('description');
            $table->longtext('services');
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
        Schema::dropIfExists('planners');
    }
};
