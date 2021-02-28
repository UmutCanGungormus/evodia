<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_categories', function (Blueprint $table) {
            $table->bigIncrements("id")->unsigned();
            $table->json("title")->nullable();
            $table->json("description")->nullable();
            $table->json("seo_url")->nullable();
            $table->json("img_url")->nullable();
            $table->integer("top_id");
            $table->integer("rank");
            $table->integer("isActive");
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
        Schema::dropIfExists('option_categories');
    }
}
