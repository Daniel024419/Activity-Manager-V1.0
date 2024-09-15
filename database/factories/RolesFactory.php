<?php

namespace Database\Factories;

use App\Enums\Roles as RoleEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Roles>
 */
class RolesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                RoleEnum::USER->value,
                RoleEnum::ADMIN->value
            ]),
            'can_add_activity' => $this->faker->boolean, // Randomly assign permission to add activities
            'can_add_admin' => $this->faker->boolean, // Randomly assign permission to add admins
            'can_update_user_role' => $this->faker->boolean, // Randomly assign permission to update user roles
            'can_create_activity' => $this->faker->boolean, // Randomly assign permission to create activities
            'can_approve_activity' => $this->faker->boolean, // Randomly assign permission to approve activities
            'can_delete_activity' => $this->faker->boolean, // Randomly assign permission to delete activities
            'can_delete_admin' => $this->faker->boolean, // Randomly assign permission to delete admins
            'can_edit_activity' => $this->faker->boolean, // Randomly assign permission to edit activities
        ];
    }
}
