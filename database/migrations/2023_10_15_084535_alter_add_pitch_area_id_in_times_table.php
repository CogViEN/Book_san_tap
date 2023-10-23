<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('times', 'pitch_area_id')) {
            Schema::table('times', function (Blueprint $table) {
                $table->unsignedBigInteger('pitch_area_id');
                $table->foreign('pitch_area_id')->references('id')->on('pitch_areas');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('times', function (Blueprint $table) {
            //
        });
    }
};
