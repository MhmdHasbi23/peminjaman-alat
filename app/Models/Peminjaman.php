<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk memperbaiki error tersebut
    protected $table = 'peminjamans';

        protected $fillable = [
            'kode_peminjaman', 
            'user_id', 
            'alat_id', 
            'jumlah', // Pastikan ini ada agar jumlah tidak tertukar/default
            'tgl_pinjam', 
            'tgl_kembali_rencana', 
            'denda',
            'status', 
            'petugas_id'
        ];

    // Relasi tetap sama...
    public function user() { return $this->belongsTo(User::class); }
    public function petugas()
    {
        // 'petugas_id' adalah nama kolom di tabel peminjaman yang menyimpan ID petugas/admin
        return $this->belongsTo(\App\Models\User::class, 'petugas_id');
    }
    public function alat() {
        return $this->belongsTo(Alat::class, 'alat_id');
    }
    public function detailPeminjaman() {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id');
    }
    public function pengembalian() { return $this->hasOne(Pengembalian::class); }
    public function logs()
    {
        // Jika log mencatat berdasarkan kode_peminjaman
        return $this->hasMany(\App\Models\ActivityLog::class, 'deskripsi', 'kode_peminjaman')
                    ->orWhere('deskripsi', 'like', '%' . $this->kode_peminjaman . '%');
    }
}