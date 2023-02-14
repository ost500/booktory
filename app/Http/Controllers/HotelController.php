<?php

namespace App\Http\Controllers;

use App\Booktory\Rservation\ReservationService;
use App\Models\Hotel;
use App\Models\Reservation;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function hotels()
    {
        try {
            $hotels = Hotel::get()->toArray();
        } catch (\Exception $exception) {
            $status = false;
        }

        return [
            'status' => $status ?? true,
            'data' => $hotels ?? []
        ];
    }

    public function hotelRegister(Request $request)
    {
        try {
            $hotel = Hotel::create($request->all());
        } catch (\Exception $exception) {
            $status = false;
        }

        return [
            'status' => $status ?? true,
            'data' => $hotel ?? null
        ];
    }

    public function reservation(Request $request, ReservationService $reservationService)
    {
        try {
            $count = $request->input('count');
            /** @var Hotel $hotel */
            $hotel = Hotel::find($request->input('hotel_id'));
            $remainRoomCount = 0;

            if (!$hotel) throw new \Exception('해당 호텔이 존재하지 않습니다');

            $remainRoomCount = $reservationService->remainRoomCount($hotel->id);

            if ($remainRoomCount < 0) throw new \Exception('객실이 매진되었습니다');

            if ($remainRoomCount - $count < 0) throw new \Exception('공실이 부족합니다');

            $reservation = Reservation::create($request->all());

        } catch (\Exception $exception) {

            $status = false;
            $msg = $exception->getMessage();
        }

        return [
            'status' => $status ?? true,
            'msg' => $msg ?? null,
            'data' => $reservation ?? ['hotel_id' => $hotel->id],
            'remainRoom' => $remainRoomCount
        ];
    }
}
