<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserTypeModel>
 */
class UserTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'common',
            'is_allowed_to_transfer' => 1,
        ];
    }

    public function merchant()
    {
        return $this->state([
            'name' => 'merchant',
            'is_allowed_to_transfer' => 0,
        ]);
    }
}
