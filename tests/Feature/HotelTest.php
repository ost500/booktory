<?php

namespace Tests\Feature;

use App\Booktory\Rservation\ReservationService;
use App\Models\Hotel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class HotelTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     * @return void
     */
    public function 호텔리스트()
    {
        $response = $this->get('/api/hotels');

        $response->assertStatus(200);
    }

    /**
     * HotelTest::호텔등록
     * @test
     */
    public function 호텔등록()
    {
        $name = $this->faker->streetName;

        $response = $this->post('/api/hotels/register', [
            'name' => $name,
            'address' => $this->faker->address,
            'room_count' => $this->faker->numberBetween(5, 10)
        ]);

//        print_r($response->decodeResponseJson());

        $response->assertJson(['data' => ['name' => $name]]);
    }



    /**
     * HotelTest::예약
     * @test
     */
    public function 예약()
    {
        $hotel = Hotel::all()->random(1)->first();

        $response = $this->post('/api/hotels/reservation', [
            'hotel_id' => $hotel->id,
            'user_name' => $this->faker->userName,
            'count' => $this->faker->numberBetween(5, 10)
        ]);

//        print_r($response->decodeResponseJson());

        $response->assertJson(['data' => ['hotel_id' => $hotel->id]]);
    }

    /**
     * @test
     */
    public function 남은방_갯수_구하기()
    {
        $hotel = Hotel::all()->random(1)->first();

        $useRoomCount = app(ReservationService::class)->remainRoomCount($hotel->id);

        $this->assertIsNumeric($useRoomCount);
    }
}
