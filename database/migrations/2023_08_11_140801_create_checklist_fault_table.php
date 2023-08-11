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
        Schema::create('checklist_fault', function (Blueprint $table) {
            $table->unsignedBigInteger('checklist_id')->nullable();
            $table->unsignedBigInteger('fault_id')->nullable();
            $table->foreign('checklist_id')->references('id')->on('checklists')->onDelete('cascade');
            $table->foreign('fault_id')->references('id')->on('faults')->onDelete('cascade');
            $table->primary(['checklist_id', 'fault_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_fault');
    }
};
