<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements("id")->unsigned();
            $table->json("title")->nullable();
            $table->json("seo_url")->nullable();
            $table->json("description");
            $table->json("price");
            $table->json("features");
            $table->integer("rank");
            $table->integer("isActive");
            $table->integer("isHome");
            $table->integer("isDiscount");
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
        Schema::dropIfExists('products');
    }
}
