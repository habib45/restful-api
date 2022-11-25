<?php

namespace Database\Factories;

use App\Models\wf_resolution;
use Illuminate\Database\Eloquent\Factories\Factory;

class wf_resolutionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = wf_resolution::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'description' => $this->faker->word,
        'color' => $this->faker->word,
        'wf_track_id' => $this->faker->randomDigitNotNull,
        'is_active' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
