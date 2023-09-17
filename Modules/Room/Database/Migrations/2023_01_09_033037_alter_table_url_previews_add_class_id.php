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
        Schema::table("url_previews", function (Blueprint $table) {
            $table->unsignedBigInteger('live_class_id');
            $table->foreign('live_class_id')->references("id")->on("lives");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("url_previews", function (Blueprint $table) {
            $table->dropForeign(['live_class_id']);
            $table->dropColumn('live_class_id');
        });
    }
};
