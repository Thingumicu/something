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
        Schema::create('lessons', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('classids')->nullable();
            $table->string('subjectid');
            $table->string('periodspercard');
            $table->string('periodsperweek');
            $table->string('teacherids');
            $table->string('groupids')->nullable();
            $table->string('termsdefid')->nullable();
            $table->string('weeksdefid');
            $table->string('daysdefid');
            $table->foreign('classids')->references('id')->on('classes');
            $table->foreign('subjectid')->references('id')->on('subjects');
            $table->foreign('teacherids')->references('id')->on('teachers');
            //$table->foreign('groupids')->references('divisiontag')->on('groups');
            $table->foreign('termsdefid')->references('id')->on('termsdefs');
            $table->foreign('weeksdefid')->references('id')->on('weeksdefs');
            $table->foreign('daysdefid')->references('id')->on('daysdefs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
