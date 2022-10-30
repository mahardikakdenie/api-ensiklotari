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
        Schema::table("instructors", function(Blueprint $table) {
            $table->foreignId("studio_id")->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("instructors", function(Blueprint $table) {
            $table->dropForeign(["studio_id"]);
            $table->dropColumn("studio_id");
        });
    }
};
