<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_reports', function (Blueprint $table) {
            $table->renameColumn('report_id', 'id');
            $table->renameColumn('p_id', 'product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_reports', function (Blueprint $table) {
            $table->renameColumn('id', 'report_id');
            $table->renameColumn('product_id', 'p_id');
        });
    }
};
