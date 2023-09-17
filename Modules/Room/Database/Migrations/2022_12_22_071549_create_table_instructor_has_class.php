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
        Schema::create('instructor_has_class', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("live_class_id");
            $table->foreign("live_class_id")->references("id")->on("lives");
            $table->unsignedBigInteger("instructor_id");
            $table->foreign("instructor_id")->references("id")->on("users");
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
        Schema::dropIfExists('instructor_has_class');
    }
};
