<?php

namespace Database\Factories;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Subject::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            "id_type" => $this->faker->randomElement([
                "1",
                "2",
                "3"
            ]),
            'code' => $this->faker->name(),
            'created_by' => $this->faker->name(),
            'modified_by' => $this->faker->name(''),
        ];
    }
}
