<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->bigIncrements("id")->unsigned();
            $table->bigInteger("product_id")->unsigned();
            $table->bigInteger("category_id")->unsigned();
            $table->json("stock");
            $table->json("price")->nullable();
            $table->json("img_url")->nullable();
            $table->integer("rank");
            $table->integer("isActive");
            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade");
            $table->foreign("category_id")->references("id")->on("option_categories")->onDelete("cascade");
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
        Schema::dropIfExists('options');
    }
}
