<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $public_date = $this->faker->dateTimeBetween('-3 month', '+6 months');
        $deadline_date = $this->faker->dateTimeBetween($public_date, '+6 months');
        return [
            'project_number' => $this->faker->numberBetween(10000000,99999999),
            'name' => ucwords($this->faker->words(mt_rand(3,5), true)),
            'category_id' => Category::all()->random()->id,
            'description' => $this->faker->paragraphs(mt_rand(2,5), true),
            'deadline_date' => $deadline_date,
            'deadline_time' => $this->faker->time('H:i'),
            'timezone' => $this->faker->randomElement(['America/New_York', 'America/Chicago', 'America/Denver', 'America/Phoenix', 'America/Los_Angeles', 'America/Anchorage', 'America/Adak', 'Pacific/Honolulu']),
            'public_date' => $public_date,
            'deadline_beyond' => $this->faker->randomElement([1, 30, 60, 90, 1000000]),
            'walkthrough' => $this->faker->boolean(70),
            'rfps' => [
                $this->faker->url(),
                $this->faker->url(),
                $this->faker->url(),
                $this->faker->url(),
                $this->faker->url()
            ],
            'addendums' => [
                $this->faker->url(),
                $this->faker->url(),
                $this->faker->url(),
                $this->faker->url(),
                $this->faker->url()
            ],
            'status' => 'active',
        ];
    }
    

    public function withUserId($user_id)
    {
        return $this->state([
            'user_id' => $user_id,
        ]);
    }

}
