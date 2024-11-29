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
        Schema::create('triggers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type',['event','time']);
            $table->string('params');
            $table->foreignId('workflow_id')->constrained('workflows')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('conditions', function (Blueprint $table) {
            $table->id();
            $table->string('criteria');
            $table->foreignId('workflow_id')->constrained('workflows')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('params');
            $table->foreignId('workflow_id')->constrained('workflows')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('execution_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_id')->constrained('workflows')->onDelete('cascade');
            $table->boolean('result');
            $table->string('details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('triggers');
        Schema::dropIfExists('conditions');
        Schema::dropIfExists('actions');
        Schema::dropIfExists('execution_logs');
    }
};
