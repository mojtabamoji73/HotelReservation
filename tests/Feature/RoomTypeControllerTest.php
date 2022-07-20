<?php

namespace Tests\Feature;

use App\Models\RoomType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class RoomTypeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        Cache::shouldReceive('get')
        ->once()
        ->with('key')
        ->andReturn('value');
        $response = $this->get('/room_types');

        $response->assertStatus(200)
        ->assertSeeText('Name')
        ->assertViewIs('roomType.index');
    }
    
    public function testUpdateFile(){

        $file = UploadedFile::fake()->image('sample.jpg');
        $roomType = RoomType::factory()->create();
        $response = $this->put("/room_types/{$roomType->id}",
        ['picture' => $file]
    );
    $response->assertStatus(302)
    ->assertRedirect('/room_types');
    Storage::disk('public')->assertExists($file->hashName());
    }
}
