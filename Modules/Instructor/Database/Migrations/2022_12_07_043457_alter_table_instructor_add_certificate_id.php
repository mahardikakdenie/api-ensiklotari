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
            $table->foreignId("certificate_id")->nullable()->constrained();
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
            $table->dropForeign(["certificate_id"]);
            $table->dropColumn("certificate_id");
        });
    }
};
