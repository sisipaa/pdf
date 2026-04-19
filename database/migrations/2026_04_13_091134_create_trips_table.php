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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['dalam_negeri', 'luar_negeri']);
            $table->string('nomor_surat')->nullable();
            $table->date('tanggal_keberangkatan');
            $table->string('nama');
            $table->string('nip');
            $table->string('pangkat');
            $table->string('golongan');
            $table->string('jabatan');
            $table->text('maksud_perjalanan');
            $table->enum('jenis_angkutan', ['darat', 'udara']);
            $table->string('tempat_keberangkatan');
            $table->string('tujuan');
            $table->integer('lama_hari');
            $table->date('tanggal_kembali');
            $table->decimal('uang_harian_per_hari', 15, 2);
            $table->decimal('total_uang_harian', 15, 2);
            $table->string('jenis_transport')->nullable(); // luar kota, taxi, dalam kota
            $table->decimal('biaya_transport', 15, 2)->default(0);
            $table->decimal('biaya_hotel', 15, 2)->default(0);
            $table->decimal('total_biaya', 15, 2);
            $table->string('mata_uang')->default('IDR'); // IDR atau USD
            $table->string('file_pdf')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
