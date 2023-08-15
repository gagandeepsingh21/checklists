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
        Schema::create('checklist_class', function (Blueprint $table) {
            $table->unsignedBigInteger('checklist_id')->nullable();
            $table->unsignedBigInteger('class_id')->nullable();
            $table->foreign('checklist_id')->references('id')->on('checklists')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('faults')->onDelete('cascade');
            $table->primary(['checklist_id', 'class_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_class');
    }
};
