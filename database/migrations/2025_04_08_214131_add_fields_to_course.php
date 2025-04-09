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
        Schema::table('courses', function (Blueprint $table) {
            $table->text('learning_outcomes')->nullable();
            $table->unsignedInteger('instructor_id')->nullable();
            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('set null');
            $table->string('course_duration')->nullable();
            $table->text('target_audience')->nullable();
            $table->text('course_topics')->nullable();
            $table->text('prerequisites')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('learning_outcomes');
            $table->dropColumn('target_audience');
            $table->dropForeign(['instructor_id']);
            $table->dropColumn('instructor_id');
            $table->dropColumn('course_duration');
            $table->dropColumn('course_topics');
            $table->dropColumn('prerequisites');
        });
    }
};
