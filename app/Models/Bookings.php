<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    /** @use HasFactory<\Database\Factories\BookingsFactory> */
    protected $primaryKey = 'id_booking';
    protected $fillable = ['user_id', 'id_konsol', 'start_time', 'end_time', 'status'];

    public function console()
    {
        return $this->belongsTo(Console::class, 'id_konsol');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    use HasFactory;
}
