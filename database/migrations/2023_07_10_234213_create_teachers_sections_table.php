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
        Schema::create('teachers_sections', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('Teacher_id')->unsigned();
            $table->foreign('Teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->bigInteger('Section_id')->unsigned();
            $table->foreign('Section_id')->references('id')->on('sections')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers_sections');
    }
};
