<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

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
        return [
            'p_id' => rand(1, 20),
            'remaining_qty' => rand(1, 10),
            'report_date' => Carbon::now()->subDays(rand(0, 365))->toDateString(),
        ];
    }
}
