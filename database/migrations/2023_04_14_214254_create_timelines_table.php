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
        Schema::create('timelines', function (Blueprint $table) {
            $table->id();
            $table->string('description'); // paused or resume
            $table->dateTime('date_and_time');
            $table->string('time_before_resume')->nullable();
            // -- Paused At : 2021-04-08 12:00:00
            // -- Resume At : 2021-04-08 12:00:00 -- paused duration : 10 minutes
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
        Schema::dropIfExists('timelines');
    }
};
