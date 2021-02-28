<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string("company_name",255);
            $table->text("address");
            $table->string("logo",70);
            $table->string("mobile_logo",70);
            $table->string("favicon",70);
            $table->string("phone_1",15);
            $table->string("phone_2",15);
            $table->string("fax_1",15);
            $table->string("fax_2",15);
            $table->string("facebook",70);
            $table->string("twitter",70);
            $table->string("instagram",70);
            $table->string("youtube",70);
            $table->string("linkedin",70);
            $table->string("meta_keywords",255);
            $table->string("meta_description",255);
            $table->text("analytics");
            $table->text("metrica");
            $table->text("live_support");
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
        Schema::dropIfExists('settings');
    }
}
