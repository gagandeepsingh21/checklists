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
        Schema::create('faults_checked', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checklist_id')->default(0);
            $table->unsignedBigInteger('fault_id')->nullable();
            $table->longText('message')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('checklist_id')->references('id')->on('checklists');
            $table->foreign('fault_id')->references('id')->on('faults');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faults_checked');
    }
};
