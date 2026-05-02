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
        Schema::create('massas', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('nik', 16)->unique();
            $table->string('full_name');
            $table->enum('gender', ['M', 'F']);
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth');
            $table->string('phone_number', 20);
            $table->string('email');
            $table->text('address');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->string('province_id');
            $table->string('regency_id');
            $table->string('district_id');
            $table->string('village_id');
            $table->string('postal_code', 10);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('profession')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['province_id', 'regency_id', 'district_id']);
            $table->index('phone_number');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('massas');
    }
};
