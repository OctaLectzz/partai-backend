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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('kta_number')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at');
            $table->string('password');
            $table->string('phone_number');

            // Biodata
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->enum('gender', ['M', 'F']);
            $table->string('religion');
            $table->string('marital_status');
            $table->string('education');
            $table->string('profession');

            // Address
            $table->text('address');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('province_id');
            $table->string('regency_id');
            $table->string('district_id');
            $table->string('village_id');
            $table->string('postal_code', 5);

            // Files & Status
            $table->string('photo_url')->nullable();
            $table->string('ktp_photo_url')->nullable();
            $table->enum('role', ['admin', 'board_member', 'member', 'sympathizer'])->default('member');
            $table->boolean('status')->default(true); // true = active, false = inactive

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
