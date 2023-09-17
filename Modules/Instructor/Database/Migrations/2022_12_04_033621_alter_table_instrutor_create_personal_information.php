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
        Schema::table('instructors', function (Blueprint $table) {
            $table->string("facebook")->nullable();
            $table->string("instagram")->nullable();
            $table->string('twitter')->nullable();
            $table->string("email")->nullable();
            $table->string("gender")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instructors', function (Blueprint $table) {
            $table->dropColumn("facebook");
            $table->dropColumn("instagram");
            $table->dropColumn('twitter');
            $table->dropColumn("email");
        });
    }
};
