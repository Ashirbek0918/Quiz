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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->integer("attempts_count")->default(1);
            $table->time("duration");
            $table->datetime("from_date");
            $table->datetime("to_date");
            $table->json("topics");
            $table->boolean('status')->default(true);
            $table->tinyInteger('is_protected')->default(0);
            $table->string('lang')->default('ru');
            $table->tinyInteger('show_correct_answers')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
