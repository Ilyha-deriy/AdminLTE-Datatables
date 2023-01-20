<?php

namespace Database\Factories;

use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $array_numbers = array('38044', '38048', '38032', '38050', '38066', '38095', '38099', '38063',
        '38073', '38093', '38067', '38068', '38096', '38097', '38098', '38091', '38092', '38094');
        $phone_number = array_rand(array_flip($array_numbers)) . rand(1000000, 9999999);
        $phone = PhoneNumber::make($phone_number, 'UA');
        return [
                'name' => fake()->unique()->name(),
                'position_id' => Position::all()->random()->id,
                'email' => fake()->unique()->safeEmail(),
                'recruitment_date' => Carbon::now()->subYears(rand(0, 7))->format('Y-m-d'),
                'image_path' => 'profile.jpg',
                'phone_number' => $phone->formatInternational(),
                'payment' => number_format(rand(500, 500000)),
                'head_id' => null,
                'admin_created_id' => User::all()->random()->id,
                'admin_updated_id' => User::all()->random()->id,
        ];
    }
}
