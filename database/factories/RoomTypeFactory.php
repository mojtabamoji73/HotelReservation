<?php

namespace Database\Factories;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomTypeFactory extends Factory
{
    protected $model = RoomType::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
            return [
                'name' => $this->faker->name,
                'description' => $this->faker->text,
                'deleted_at' => $this->faker->date,
            ];
    }
}
