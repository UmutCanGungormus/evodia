<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_settings', function (Blueprint $table) {
            $table->id();
            $table->json("protocol")->nullable();
            $table->json("host")->nullable();
            $table->json("port")->nullable();
            $table->json("user")->nullable();
            $table->json("password")->nullable();
            $table->json("from")->nullable();
            $table->json("to")->nullable();
            $table->json("user_name")->nullable();
            $table->integer("isActive")->nullable();
            $table->integer("rank")->nullable();
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
        Schema::dropIfExists('email_settings');
    }
}
