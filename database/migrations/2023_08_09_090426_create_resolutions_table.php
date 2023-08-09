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
        Schema::create('resolutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faultschecked_id')->default(0);
            $table->unsignedBigInteger('resolved_by')->nullable();
            $table->date('date_resolved')->nullable();
            $table->longText('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('faultschecked_id')->references('id')->on('faults_checked');
            $table->foreign('resolved_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resolutions');
    }
};
