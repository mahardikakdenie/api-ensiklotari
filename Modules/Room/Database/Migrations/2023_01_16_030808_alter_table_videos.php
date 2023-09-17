<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("videos", function (Blueprint $table) {
            $table->longText("data_videos");
            $table->longText("data_previews")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("videos", function (Blueprint $table) {
            $table->dropColumn("data_videos");
            $table->dropColumn("data_previews");
        });
    }
};
