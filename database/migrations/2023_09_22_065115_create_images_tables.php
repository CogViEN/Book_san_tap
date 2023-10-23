<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->integer('object-id');
            $table->string('path');
            $table->integer('type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('images_tables');
    }
};
