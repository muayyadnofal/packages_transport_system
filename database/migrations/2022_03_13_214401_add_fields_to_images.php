<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToImages extends Migration
{
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->boolean('upload_successful')->default(false);
            $table->string('disk')->default('public');
        });
    }

    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn(['disk', 'upload_successful']);
        });
    }
}
