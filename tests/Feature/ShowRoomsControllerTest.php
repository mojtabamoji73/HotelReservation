<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\RoomType;
use App\Models\Room;

class ShowRoomsControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_rooms()
    {
        $response = $this->get('/rooms');

        $response->assertStatus(200)
        ->assertSeeText('Type')
        ->assertViewIs('rooms.index')
        ->assertViewHas('rooms');
    
    }

    public function testRoomParameter(){

        $roomTypes = RoomType::factory()->count(3)->create();
        $rooms = Room::factory()->count('20')->create();
        $roomType = $roomTypes->random();

        $response = $this->get('/rooms/'.$roomType->id);

        $response->assertStatus(200)
        ->assertSeeText('Type')
        ->assertViewIs('rooms.index')
        ->assertViewHas('rooms')
        ->assertSeeText($roomType->name);
    }
}
