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
        Schema::table("studios", function (Blueprint $table) {
            $table->unsignedBigInteger("media_id");
            $table->foreign("media_id")->on("medias")->references("id");
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("studios", function (Blueprint $table) {
            $table->dropForeign(["media_id"]);
            $table->dropColumn("media_id");
        });
    }
};
