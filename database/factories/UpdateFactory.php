<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Roles;
use App\Models\Update;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Update>
 */
class UpdateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Update::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $role_id = Roles::where('name', \App\Enums\Roles::USER->value)->first()->id;

        return [
            'activity_id' => Activity::factory(), // Creates a new activity or references an existing one
            'user_id' => User::where('role_id', $role_id)->inRandomOrder()->first()->id ?? rand(1, 2), // Creates a new user or references an existing one
            'status' => $this->faker->randomElement(['done', 'pending']), // Randomly selects status
            'remark' => $this->faker->sentence, // Generates a random sentence as a remark
            'updated_at' => $this->faker->dateTimeThisMonth(), // Generates a random date and time within the current month
        ];
    }
}
