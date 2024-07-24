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
        Schema::create('stock_predictions', function (Blueprint $table) {
            $table->string('ticker_symbol')->primary();
            $table->string('company_name');
            $table->float('confidence', 10, 8);
            $table->json('predictions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_predictions');
    }
};
