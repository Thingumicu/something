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
            $table->string('id')->primary()->nullable();
            $table->text('classids')->nullable();
            $table->string('subjectid');
            $table->string('periodspercard');
            $table->string('periodsperweek');
            $table->string('teacherids',255)->nullable();
            $table->text('groupids')->nullable();
            $table->string('termsdefid')->nullable();
            $table->string('weeksdefid');
            $table->string('daysdefid');
            $table->timestamps();

            //$table->foreign('classids')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('subjectid')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('teacherids')->references('id')->on('teachers')->onDelete('cascade');
            //$table->foreign('groupids')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('termsdefid')->references('id')->on('termsdefs')->onDelete('cascade');
            $table->foreign('weeksdefid')->references('id')->on('weeksdefs')->onDelete('cascade');
            //$table->foreign('daysdefid')->references('id')->on('daysdefs')->onDelete('cascade');

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
