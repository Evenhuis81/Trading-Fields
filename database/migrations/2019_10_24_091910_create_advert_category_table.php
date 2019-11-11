<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advert_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('advert_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
            $table->foreign('advert_id')->references('id')->on('adverts')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advert_category');
    }
}
