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
        Schema::create('ktas', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('kta_number')->unique();
            $table->string('name');
            $table->string('phone_number', 20);
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->enum('gender', ['M', 'F']);
            $table->string('position');
            $table->text('address');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->string('province_id');
            $table->string('regency_id');
            $table->string('district_id');
            $table->string('village_id');
            $table->string('postal_code', 10);
            $table->string('photo');
            $table->boolean('is_council')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ktas');
    }
};
