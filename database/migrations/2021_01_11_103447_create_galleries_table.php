<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->bigIncrements("id")->unsigned();;
            $table->json("title")->nullable();
            $table->json("seo_url")->nullable();
            $table->json("img_url")->nullable();
            $table->json("description")->nullable();
            $table->string("type")->nullable();
            $table->integer("rank");
            $table->integer("isActive")->default(1);
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
        Schema::dropIfExists('galleries');
    }
}
