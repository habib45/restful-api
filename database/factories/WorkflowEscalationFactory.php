<?php

namespace Database\Factories;

use App\Models\WorkflowEscalation;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkflowEscalationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkflowEscalation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'is_global' => $this->faker->word,
        'api_apps_id' => $this->faker->randomDigitNotNull,
        'enable_email_notification' => $this->faker->word,
        'is_assign_role' => $this->faker->word,
        'access_type' => $this->faker->word,
        'access_type_values' => $this->faker->word,
        'is_state_change' => $this->faker->word,
        'status' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
