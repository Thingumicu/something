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
            $table->string('lessonid')->nullable();
            $table->string('classroomids')->nullable();
            $table->string('period');
            $table->string('weeks');
            $table->string('terms');
            $table->string('days');
            $table->foreign('lessonid')->references('id')->on('lessons')->onDelete('cascade');
            //$table->foreign('classroomids')->references('name')->on('classrooms')->onDelete('cascade');
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
