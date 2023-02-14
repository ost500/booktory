<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $inventory
 */
class Hotel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'room_count', 'inventory'];
//    protected $appends = ['inventory'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
