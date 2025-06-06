<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accesories extends Model
{
    /** @use HasFactory<\Database\Factories\AccesoriesFactory> */
    protected $primaryKey = 'id_aksesoris';
    protected $fillable = ['nama_aksesoris', 'deskripsi', 'stok', 'harga', 'gambar'];

    public function pesanan()
    {
        $this->hasMany(Pesanan::class, 'id_pesanan');
    }

    use HasFactory;
}
