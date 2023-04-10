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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('agent_name')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->text('pauses_and_resumes')->nullable(); // format as ['pause_time' => 'yyyy-mm-dd hh:mm:ss', 'resume_time' => 'yyyy-mm-dd hh:mm:ss']
            $table->dateTime('end_time')->nullable();
            $table->string('record_number')->nullable();
            $table->string('total_time_spent')->nullable();
            $table->foreignId('company_id')->constrained()->nullable();
            $table->foreignId('segment_id')->constrained()->nullable();
            $table->foreignId('task_id')->constrained()->nullable();
            $table->dateTime('submitted_at')->nullable();
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
        Schema::dropIfExists('submissions');
    }
};
