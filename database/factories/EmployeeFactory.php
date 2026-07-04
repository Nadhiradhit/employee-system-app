<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'phone_number' => $this->faker->regexify('\+628[0-9]{12}'),
            'department' => $this->faker->jobTitle(),
            'joining_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['active', 'inactive'])
        ];
    }
}
