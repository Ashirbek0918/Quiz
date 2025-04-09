<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('participant_exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('participant_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->bigInteger('exam_id');
            $table->integer('question_count');
            $table->integer('correct_answers_count')->default(0);
            $table->json('questions')->nullable();
            $table->json('participant_answers')->nullable();
            $table->longText('body')->nullable();
            $table->boolean('exists_practical')->default(false);
            $table->bigInteger('checked_by')->nullable();
            $table->json('checked_answers')->nullable();
            $table->boolean('attempt_completed')->default(false);
            $table->dateTime('finished_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_exam_attempts');
    }
};
