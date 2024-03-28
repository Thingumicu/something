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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('lessonid');
            $table->string('classroomids')->nullable();
            $table->string('period');
            $table->string('weeks');
            $table->string('terms');
            $table->string('days');

            $table->foreign('days')->references('day')->on('days')->onDelete('cascade');
            $table->foreign('weeks')->references('weeks')->on('weeks')->onDelete('cascade');
            $table->foreign('terms')->references('terms')->on('terms')->onDelete('cascade');
            $table->foreign('period')->references('period')->on('periods')->onDelete('cascade');
            $table->foreign('lessonid')->references('id')->on('lessons')->onDelete('cascade');
            $table->foreign('classroomids')->references('id')->on('classrooms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
