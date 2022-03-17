<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightsTable extends Migration
{
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('traveler_id')->references('id')->on('travelers')->onDelete('cascade');
            $table->string('launch_city');
            $table->string('landing_city');
            $table->string('launch_time');
            $table->string('landing_time');
            $table->string('launch_day');
            $table->string('landing_day');
            $table->Integer('full_load_amount');
            $table->Integer('free_load_amount');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('flights');
    }
}
