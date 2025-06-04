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
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('checked_at'); // waktu scan QR
            $table->foreignId('status_presensi_id')->constrained('status')->onDelete('restrict');
            $table->string('location')->nullable(); // lokasi presensi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
