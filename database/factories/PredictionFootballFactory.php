<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PredictionFootball;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PredictionFootball>
 */
class PredictionFootballFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = PredictionFootball::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $predicted_1 = $this->faker->boolean(33);
        if ($predicted_1) {
            $predicted_X = false;
            $predicted_2 = false;
        } else {
            $predicted_2 = $this->faker->boolean(33);
            if ($predicted_2) {
                $predicted_X = false;
            } else {
                $predicted_X = true;
            }
        }
        
        return [
            'predicted_1' => $predicted_1,
            'predicted_X' => $predicted_X,
            'predicted_2' => $predicted_2,
        ];
    }
}