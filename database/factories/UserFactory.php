<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $state = $this->faker->stateAbbr();
        $counties = Location::getCounties($state);
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'crm_id' => $this->faker->uuid(),
            'account_number' => $this->faker->ean8(),
            'company_name' => $this->faker->company(),
            'phone_number' => $this->faker->phoneNumber(),
            'fax_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->streetAddress(),
            'address_continued' => "Buidling Number " . $this->faker->buildingNumber(),
            'city' => $this->faker->city(),
            'state' => $state,
            'county' => $this->faker->randomElement($counties),
            'postal' => $this->faker->postcode(),
        ];
    }

    /**
     * Adds 'email' to model
     * @param string type = type of user
     */
    public function addEmail($email)
    {
        return $this->state(function (array $attributes) {
            return [
                'email' => $email
            ];
        });
    }

    /**
     * Adds 'type' to model for storing user types.
     * @param string type = type of user
     */
    public function addType($type)
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => $type
            ];
        });
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
                'email_verified_at' => null
            ];
        });
    }


}