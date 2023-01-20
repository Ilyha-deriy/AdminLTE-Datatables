<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $positions = array('Leading specialist of the Control Department',
        'Contextual advertisig specialist', 'Lead designer',
        'Frontend developer', 'Backend developer', 'IT Manager',
        'Cashier', 'Computer Support Specialist', 'Computer Systems Administrator',
        'Budget analyst', 'HR Specialist', 'Market Research Analyst');
        return [
            'name' => array_rand(array_flip($positions)),
            'admin_created_id' => User::all()->random()->id,
            'admin_updated_id' => User::all()->random()->id,
        ];
    }
}
