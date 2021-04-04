<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('rating');
            $table->string('category');
            $table->string('image')->nullable();
            $table->integer('reputation');
            $table->double('price');
            $table->integer('availability');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('create_user_id');
            $table->unsignedBigInteger('update_user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // RELATIONS
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('create_user_id')->references('id')->on('users');
            $table->foreign('update_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}
