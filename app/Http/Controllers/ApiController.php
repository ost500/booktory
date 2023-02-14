<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class ApiController extends Controller
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
}
