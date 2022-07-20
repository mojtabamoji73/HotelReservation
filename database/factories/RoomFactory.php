<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\support\facades\DB;

class RoomFactory extends Factory
{
    protected $model = Room::class;
    /**
     * Define the model's default state.
     *
     * @return array
     * 
     * 
     */
    public function definition()
    {
        $roomTypes = DB::table('room_types')->pluck('id')->all();
            return [
                'number' => $this->faker->unique()->randomNumber(),
                'room_type_id' => $this->faker->randomElement($roomTypes),
            ];
        
    }
}
