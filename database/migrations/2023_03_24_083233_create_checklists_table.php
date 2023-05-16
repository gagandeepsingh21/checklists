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
        Schema::create('checklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(0);
            $table->string('building_name');
<<<<<<< HEAD
            $table->string('class_name');
            $table->string('faults_identified');
            $table->string('message');
=======
            $table->string('class_name')->nullable();
            $table->string('faults_identified');
            $table->string('message');
            $table->string('status')->default('pending');
>>>>>>> strathmore/main
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklists');
    }
};
