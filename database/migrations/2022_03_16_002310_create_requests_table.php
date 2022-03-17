<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->references('id')->on('senders')->onDelete('cascade');
            $table->foreignId('flight_id')->references('id')->on('flights')->onDelete('cascade');
            $table->string('status')->default('waiting');
            $table->integer('full_weight')->default(0);
            $table->date('Acceptance_Time')->nullable();
            $table->date('Fail_Time')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
