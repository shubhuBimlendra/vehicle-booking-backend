<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['vehicle_id', 'user_id', 'seat_id', 'status'];

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
