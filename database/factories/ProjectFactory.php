<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\User;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $user = User::first();

        return [
            'name' => fake()->company(),
            'start_date' => fake()->dateTimeBetween('-2 years', '-3 days')->format('Y-m-d'),
            'end_date' => fake()->dateTimeBetween('-2 days', '2 years')->format('Y-m-d'),
            'value' => fake()->randomFloat(2, 2000, 80000),
            'status' => fake()->randomElement(['active', 'inactive']),
            'user_id' => $user->id,
        ];
    }

    public function active(): ProjectFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active',
            ];
        });
    }

    public function inactive(): ProjectFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'inactive',
            ];
        });
    }
}
