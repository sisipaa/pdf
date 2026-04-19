<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'nomor_surat',
        'tanggal_keberangkatan',
        'nama',
        'nip',
        'pangkat',
        'golongan',
        'jabatan',
        'maksud_perjalanan',
        'jenis_angkutan',
        'tempat_keberangkatan',
        'tujuan',
        'lama_hari',
        'tanggal_kembali',
        'uang_harian_per_hari',
        'total_uang_harian',
        'jenis_transport',
        'biaya_transport',
        'biaya_hotel',
        'total_biaya',
        'mata_uang',
        'file_pdf',
        'status',
    ];

    protected $casts = [
        'tanggal_keberangkatan' => 'date',
        'tanggal_kembali' => 'date',
        'uang_harian_per_hari' => 'decimal:2',
        'total_uang_harian' => 'decimal:2',
        'biaya_transport' => 'decimal:2',
        'biaya_hotel' => 'decimal:2',
        'total_biaya' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
