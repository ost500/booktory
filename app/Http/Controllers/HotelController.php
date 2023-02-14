<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
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
}
