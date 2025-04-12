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
        Schema::table('examinations', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->integer('number_of_questions')->nullable();
            $table->string('exam_duration')->nullable();
            $table->decimal('total_point')->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('number_of_questions');
            $table->dropColumn('exam_duration');
            $table->dropColumn('total_point');
        });
    }
};
