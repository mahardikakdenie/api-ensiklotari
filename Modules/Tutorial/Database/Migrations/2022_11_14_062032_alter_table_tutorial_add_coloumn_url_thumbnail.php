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
        Schema::table("tutorials", function (Blueprint $table) {
            $table->string("url_thumbnail");
            $table->string("slug");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("tutorials", function (Blueprint $table) {
            $table->dropColumn("url_thumbnail");
            $table->dropColumn("slug");
        });
    }
};
