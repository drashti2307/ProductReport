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
            'product_id' => rand(1, Product::MAX('id')),
            'report_date' => $faker->dateTimeBetween('2025-06-01', '2025-07-31'),
            'remaining_qty' => rand(1, 10),
        ];
    }
}
