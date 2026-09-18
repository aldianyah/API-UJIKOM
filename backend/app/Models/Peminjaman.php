<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Tambahkan baris ini biar Laravel tidak mencari tabel 'peminjamen'
    protected $table = 'peminjaman';

    protected $guarded = ['id'];

    // Relasi ke User (peminjam)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke DetailPinjam
    public function detailPinjams()
    {
        return $this->hasMany(DetailPinjam::class);
    }

    // Relasi ke Pengembalian
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }
}