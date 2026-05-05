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
        Schema::create('event_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('massa_id')->constrained('massas')->cascadeOnDelete();
            $table->string('participant_code')->unique();
            $table->text('message')->nullable();
            $table->enum('status', ['registered', 'attended'])->default('registered');
            $table->timestamp('attended_at')->nullable();
            $table->timestamps();

            $table->unique(['event_id', 'massa_id']); // One registration per massa per event
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_participants');
    }
};
