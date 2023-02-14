<?php

namespace App\Booktory\Rservation;

use App\Models\Hotel;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    public function remainRoomCount($hotelId): int
    {

        $hotel = Hotel::where('hotels.id', $hotelId)
            ->select('hotels.*', 'reservations.*', DB::raw('SUM(reservations.count) as remain_count'))
            ->leftJoin('reservations', function ($q) {
                $q->on('reservations.hotel_id', '=', 'hotels.id')
                    ->where('status', '=', 'active');
            })
            ->groupBy('reservations.hotel_id')
            ->first();

        $useCount = $hotel->remain_count;

        if (!$useCount) {
            return $hotel->room_count;
        }

        return $hotel->room_count - $useCount;
    }

}
