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
        Schema::create('council_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Activity Information
            $table->string('title');
            $table->text('description');
            $table->enum('report_type', ['meeting', 'visit', 'socialization', 'supervision', 'aspiration', 'other'])->default('other');
            $table->date('activity_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location');

            // Report Details
            $table->integer('participants_count')->nullable();
            $table->text('agenda')->nullable();
            $table->text('result')->nullable();
            $table->text('recommendation')->nullable();

            // Status
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft');
            $table->text('rejection_note')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('council_reports');
    }
};
