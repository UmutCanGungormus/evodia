<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("gallery_id")->unsigned();;
            $table->string("img_url");
            $table->string("title");
            $table->longText("description");
            $table->integer("rank");
            $table->integer("isActive");
            $table->foreign("gallery_id")->references("id")->on("galleries")->onDelete("cascade");
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
        Schema::dropIfExists('gallery_files');
    }
}
