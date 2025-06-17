<?php

namespace Database\Seeders;

use App\Models\ProductReport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       ProductReport::factory(5)->create();
    }
}
