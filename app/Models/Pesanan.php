<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    /** @use HasFactory<\Database\Factories\PesananFactory> */
    protected $primaryKey = 'id_pesanan';
    protected $fillable = ['user_id', 'id_aksesoris', 'quantity', 'jumlah_pembayaran', 'snap_token','status'];

    public function users()
    {
        $this->belongsTo(User::class, 'user_id');
    }

    public function aksesoris()
    {
        $this->belongsTo(Accesories::class, 'id_aksesoris');
    }

    use HasFactory;
}
