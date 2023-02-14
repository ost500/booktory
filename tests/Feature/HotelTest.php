<?php

namespace Tests\Feature;

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
}
