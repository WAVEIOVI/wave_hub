<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'client_id' => $this->faker->word(),
            'client_name' => $this->faker->company(),
            // 'client_website' => $this->faker->url(),
            // 'main_phone_number' => $this->faker->phoneNumber(),
            // 'secondary_phone_number' => $this->faker->phoneNumber(),
            // 'client_email' => $this->faker->unique()->safeEmail(),
            // 'address' => $this->faker->address(),
            // 'postcode' => $this->faker->postcode(),
            // 'city' => $this->faker->city(),
            // 'country' => 'Tunisia', // Default value
            'client_type' => $this->faker->word(),
            'client_activity' => $this->faker->word(),
            'client_status' => 'pending', // Default value
            // Add more fields as needed
        ];
    }
}
