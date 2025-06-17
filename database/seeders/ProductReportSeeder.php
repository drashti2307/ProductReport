<?php

namespace Database\Seeders;

use App\Models\ProductReport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //ProductReport::factory(5)->create();
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('product_reports')->insert([
                'p_id' => rand(1, 10),
                'report_date' => $faker->dateTimeBetween('2025-06-01', 'now'),
                'remaining_qty' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
