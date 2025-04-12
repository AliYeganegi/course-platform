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
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->string('quiz_link')->nullable();
            $table->enum('quiz_status', ['active', 'inactive'])->default('inactive');
            $table->dateTime('quiz_start_datetime')->nullable();
            $table->dateTime('quiz_end_datetime')->nullable();
            $table->integer('quiz_number_of_attempts')->default(1);
            $table->unsignedInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};
