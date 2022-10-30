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
        Schema::table("instructors", function (Blueprint $table) {
            $table->unsignedBigInteger("media_id");
            $table->foreign("media_id")->references("id")->on("medias");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("instructors", function (Blueprint $table) {
            $table->dropForeign(["media_id"]);
            $table->dropColumn("media_id");
        });
    }
};
