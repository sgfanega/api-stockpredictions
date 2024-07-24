<?php

namespace Database\Factories;

use App\Models\StockPrediction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockPrediction>
 */
class StockPredictionFactory extends Factory
{

    protected $model = StockPrediction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticker_symbol' => $this->generateTickerSymbol(),
            'company_name' => $this->faker->company,
            'confidence' => $this->faker->randomFloat(2, 90, 99),
            'predictions' => $this->generatePredictions()
        ];
    }

    /**
     * Generate a random ticker symbol with 1-5 uppercase letters.
     * 
     * @return string
     */
    public function generateTickerSymbol()
    {
        do {
            $length = rand(1, 5);
            $ticker_symbol = strtoupper(($this->faker->lexify(str_repeat('?', $length))));
        } while (StockPrediction::where('ticker_symbol', $ticker_symbol)->exists());

        return $ticker_symbol;
    }

    /**
     * Generate a sample predictions array.
     * 
     * @return array<string, int>
     */
    private function generatePredictions()
    {
        $predictions = [];

        for ($index = 1; $index < 31; $index++) {
            $predictions["day $index"] = $this->faker->randomFloat(2, 1, 200);
        }

        return $predictions;
    }
}
