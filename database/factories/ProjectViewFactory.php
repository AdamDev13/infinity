<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectView;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectViewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectView::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
//            "viewed_at" => $this->faker->dateTimeBetween("-1 day", "2 months");
        ];
    }

    public function withIds($user_id, $project_id)
    {
        return $this->state([
            'user_id' => $user_id,
            'project_id' => $project_id,
        ]);
    }

}
