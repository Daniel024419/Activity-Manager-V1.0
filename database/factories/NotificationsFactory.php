<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notifications>
 */
class NotificationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $activities = Activity::pluck('id')->toArray();
        return [
            'action' => $this->faker->sentence,
            'activity_id' => $this->faker->randomElement($activities),
            'created_by' => rand(1, 2)
        ];
    }
}
