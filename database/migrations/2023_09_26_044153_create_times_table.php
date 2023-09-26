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
        Schema::create('times', function (Blueprint $table) {
            $table->foreignId('pitch_id')
                ->constraint()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('timeslot');
            $table->integer('cost');
            $table->timestamp('created_at');
            $table->primary(['pitch_id', 'timeslot']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('times');
    }
};
