<?php

namespace App\Booktory\Rservation;

use App\Models\Hotel;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    public function remainRoomCount($hotelId)
    {
        $hotels = Hotel::where('hotels.id', $hotelId)
            ->join('reservations', function ($q) {
                $q->on('reservations.hotel_id', '=', 'hotels.id')
                    ->where('status', '!=', 'rejected');
            })
            ->get();

        $useCount = $hotels->sum('count');

        if ($hotels->isEmpty()) {
            return 0;
        }

        return $hotels->first()->room_count - $useCount;
    }

}
