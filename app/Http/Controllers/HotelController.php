<?php

namespace App\Http\Controllers;

use App\Booktory\Rservation\ReservationService;
use App\Models\Hotel;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function hotels(ReservationService $reservationService)
    {
        try {
            /** @var Collection $hotels */
            $hotels = Hotel::get();

            $hotels->map(function (Hotel $hotel) use ($reservationService) {
                $remainRoomCount = $reservationService->remainRoomCount($hotel->id);
                $hotel->remain_room = $remainRoomCount;

                $hotel->soldout = false;
                if ($remainRoomCount < 1) {
                    $hotel->soldout = true;
                }
            });

        } catch (\Exception $exception) {
            $status = false;
        }

        return [
            'status' => $status ?? true,
            'data' => $hotels->toArray() ?? []
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

    public function reservation($hotelId, Request $request, ReservationService $reservationService)
    {
        try {
            $count = $request->input('count');
            /** @var Hotel $hotel */
            $hotel = Hotel::find($hotelId);
            $remainRoomCount = 0;

            if (!$hotel) throw new \Exception('해당 호텔이 존재하지 않습니다');

            $remainRoomCount = $reservationService->remainRoomCount($hotel->id);

            if ($remainRoomCount < 0) throw new \Exception('객실이 매진되었습니다');

            if ($remainRoomCount - $count < 0) throw new \Exception('공실이 부족합니다');

            $reservation = Reservation::create(array_merge(['hotel_id' => $hotel->id], $request->all()));

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

    public function reservationStatus($reservationId, Request $request)
    {
        try {
            $status = $request->status;
            $reservation = Reservation::whereId($reservationId)->first();

            $reservation->update([
                'status' => $status
            ]);
        } catch (\Exception $exception) {
            $status = false;
        }

        return [
            'status' => $status ?? true,
            'data' => $reservation ?? []
        ];
    }
}
