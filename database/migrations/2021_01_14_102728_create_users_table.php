<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("full_name");
            $table->string("tc",11);
            $table->string("phone",11);
            $table->string("user_name");
            $table->string("email");
            $table->string("password");
            $table->string("role");
            $table->string("password_key")->nullable();
            $table->string("sms_activation")->nullable();
            $table->string("sms_status")->nullable();
            $table->string("status")->nullable();
            $table->integer("isActive");
            $table->integer("rank");
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
        Schema::dropIfExists('users');
    }
}
