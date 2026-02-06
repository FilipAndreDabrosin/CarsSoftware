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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->char('registration_number', 7);
            $table->string('type');
            $table->string('priority')->default('Medium');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('estimated_cost');
            $table->integer('real_cost')->nullable();
            $table->date('scheduled_date');
            $table->date('completed_date')->nullable();
            $table->string('mechanic')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
