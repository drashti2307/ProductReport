<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductReport>
 */
class ProductReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create();
        return [
            'p_id' => rand(1, 10),
            'report_date' => $faker->dateTimeBetween('2025-06-01', 'now'),
            'remaining_qty' => rand(1, 10),
        ];
    }
}
