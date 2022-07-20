<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_LoggedIn()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200)
        ->assertSeeText('You are logged in');
    }

    public function test_LoggedOut(){

        $response = $this->get('/home');
        $response->assertStatus(302)
        ->assertRedirect('/login');

    }

}
