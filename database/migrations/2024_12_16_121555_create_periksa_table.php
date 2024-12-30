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
        Schema::create('periksa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('tanggalPeriksa');
            $table->text('catatan');
            $table->integer('harga');

            $table->unsignedBigInteger('daftar_poli_id')->nullable();
            $table->foreign('daftar_poli_id')->references('id')->on('daftar_poli')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periksa');
    }
};
