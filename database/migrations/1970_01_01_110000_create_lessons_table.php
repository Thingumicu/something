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
            $table->text('classids');
            $table->string('subjectid');
            $table->string('periodspercard');
            $table->string('periodsperweek');
            $table->string('teacherid');
            $table->text('groupids');
            $table->string('termsdefid')->nullable();
            $table->string('weeksdefid');
            $table->string('daysid');
            $table->timestamps();

            //$table->foreign('classids')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('subjectid')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('teacherid')->references('id')->on('teachers')->onDelete('cascade');
            //$table->foreign('groupids')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('termsdefid')->references('id')->on('terms')->onDelete('cascade');
            $table->foreign('weeksdefid')->references('id')->on('weeks')->onDelete('cascade');
            $table->foreign('daysid')->references('id')->on('days')->onDelete('cascade');

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
