<?php

namespace Database\Factories;

use App\Models\ProjectFavorite;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFavoriteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectFavorite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "status" => "active"
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
