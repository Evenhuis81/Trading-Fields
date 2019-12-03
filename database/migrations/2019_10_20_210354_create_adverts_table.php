<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('condition_id')->nullable();
            $table->unsignedInteger('price');
            $table->unsignedInteger('startbid')->nullable();
            $table->unsignedBigInteger('delivery_id');
            $table->string('name');
            $table->string('phonenr', 10)->nullable();
            $table->string('zipcode', 6);
            $table->unsignedBigInteger('owner_id');
            $table->timestamps();
            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('condition_id')->references('id')->on('conditions');
            $table->foreign('delivery_id')->references('id')->on('deliveries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adverts');
    }
}
