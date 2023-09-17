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
        Schema::table("lives", function (Blueprint $table) {
            $table->foreignId("url_preview_id")->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("lives", function (Blueprint $table) {
            $table->dropForeign(["url_preview_id"]);
            $table->dropColumn("url_preview_id");
        });
    }
};
