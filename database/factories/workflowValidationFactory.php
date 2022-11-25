<?php

namespace Database\Factories;

use App\Models\workflowValidation;
use Illuminate\Database\Eloquent\Factories\Factory;

class workflowValidationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = workflowValidation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'properties' => $this->faker->word,
        'name_space' => $this->faker->word,
        'model' => $this->faker->word,
        'status' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
