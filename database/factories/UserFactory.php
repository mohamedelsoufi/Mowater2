<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'nickname' => '',
            'phone' => $this->faker->unique()->numberBetween(45698752,63259874),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_code' => '+973',
            'password' => bcrypt('123456'), // password
            'active' => true,
            'date_of_birth' => $this->faker->dateTimeBetween('-7 days', '+2 months')->format('Y-m-d'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'nationality' =>'GCC',
            'country_id'=>1,
            'city_id'=> 1,
            'area_id'=> $this->faker->randomElement([1,2,3]),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
