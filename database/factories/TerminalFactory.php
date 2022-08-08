<?php

namespace Database\Factories;

use App\Models\Terminal;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TerminalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Terminal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->randomNumber,
            'status' => 'available',
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'ticket_id' => \App\Models\Ticket::factory(),
        ];
    }
}
