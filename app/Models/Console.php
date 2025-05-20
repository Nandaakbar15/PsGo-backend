<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Console extends Model
{
    /** @use HasFactory<\Database\Factories\ConsoleFactory> */
    protected $primaryKey = 'id_konsol';
    protected $fillable = ['name', 'description', 'hourly_rate', 'is_active', 'image'];

    public function bookings()
    {
        return $this->hasMany(Bookings::class, "id_konsol");
    }

    use HasFactory;
}
