<?php

namespace Tests\Feature;

use App\Models\StockPrediction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockPredictionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the `GET /api/stockpredictions` endpoint that returns all stock predictions in
     * the expected format.
     * 
     * @return void
     */
    public function test_index_returns_all_stock_predictions_in_valid_format() : void
    {
        $stockPredictions = StockPrediction::factory()->count(10)->create();

        $response = $this->getJson('/api/stockpredictions');

        $response->assertStatus(200);
        
        foreach ($stockPredictions as $stockPrediction) {
            $response->assertJsonFragment([
                'ticker_symbol' => $stockPrediction->ticker_symbol,
                'attributes' => [
                    'company_name' => $stockPrediction->company_name,
                    'confidence' => $stockPrediction->confidence,
                    'predictions' => $stockPrediction->predictions
                ]
            ]);
        }
    }

    /**
     * Test the `GET /api/stockpredictions/{ticker_symbol}` endpoint that returns a single stock 
     * prediction in the expected format.
     * 
     * @return void
     */
    public function test_get_returns_specific_stock_prediction_in_valid_format(): void 
    {
        $stockPrediction = StockPrediction::factory()->create([
            'ticker_symbol' => 'META',
            'company_name' => 'Meta Platforms, Inc.',
            'confidence' => 99.33,
            'predictions' => [
                'day 1' => 88.33,
                'day 2' => 45.34,
                'day 3' => 69.43,
                'day 4' => 994.30,
                'day 5' => 434.50,
                'day 6' => 434.50,
                'day 7' => 434.50,
                'day 8' => 434.50,
                'day 9' => 434.50,
                'day 10' => 434.50,
                'day 11' => 434.50,
                'day 12' => 434.50,
                'day 13' => 434.50,
                'day 14' => 434.50,
                'day 15' => 434.50,
                'day 16' => 434.50,
                'day 17' => 434.50,
                'day 18' => 434.50,
                'day 19' => 434.50,
                'day 20' => 434.78,
                'day 21' => 434.45,
                'day 22' => 434.76,
                'day 23' => 434.12,
                'day 24' => 434.34,
                'day 25' => 434.50,
                'day 26' => 434.50,
                'day 27' => 434.99,
                'day 28' => 434.50,
                'day 29' => 434.50,
                'day 30' => 434.50
            ]
        ]);

        $response = $this->getJson("/api/stockpredictions/{$stockPrediction->ticker_symbol}");

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'ticker_symbol' => $stockPrediction->ticker_symbol,
                'attributes' => [
                    'company_name' => $stockPrediction->company_name,
                    'confidence' => $stockPrediction->confidence,
                    'predictions' => $stockPrediction->predictions
                ]
            ]
        ]);
    }

    /**
     * Test the `POST /api/stockpredictions` endpoint.
     * 
     * @return void
     */
    public function test_post_stock_prediction_in_valid_format()
    {
        $stockPrediction = [
            'ticker_symbol' => 'TEST',
            'company_name' => 'Test Company Inc.',
            'confidence' => 98.32,
            'predictions' => [
                'day 1' => 150.25,
                'day 2' => 155.00,
                'day 3' => 160.00,
                'day 4' => 165.00,
                'day 5' => 170.00,
                'day 6' => 175.00,
                'day 7' => 180.00,
                'day 8' => 185.00,
                'day 9' => 190.00,
                'day 10' => 195.00,
                'day 11' => 200.00,
                'day 12' => 205.00,
                'day 13' => 210.00,
                'day 14' => 215.00,
                'day 15' => 220.00,
                'day 16' => 225.00,
                'day 17' => 230.00,
                'day 18' => 235.00,
                'day 19' => 240.00,
                'day 20' => 245.00,
                'day 21' => 250.00,
                'day 22' => 255.00,
                'day 23' => 260.00,
                'day 24' => 265.00,
                'day 25' => 270.00,
                'day 26' => 275.00,
                'day 27' => 280.00,
                'day 28' => 285.00,
                'day 29' => 290.00,
                'day 30' => 295.00
            ]
        ];

        $response = $this->postJson('/api/stockpredictions', $stockPrediction);

        $response->assertStatus(201);

        $this->assertDatabaseHas('stock_predictions', [
            'ticker_symbol' => 'TEST',
            'company_name' => 'Test Company Inc.',
            'confidence' => 98.32,
            'predictions' => json_encode($stockPrediction['predictions'])
        ]);

        $response->assertJsonFragment([
            'ticker_symbol' => 'TEST',
            'attributes' => [
                'company_name' => 'Test Company Inc.',
                'confidence' => 98.32,
                'predictions' => $stockPrediction['predictions']
            ]
        ]);
    }

    /**
     * Test `PATCH /api/stockpredictions/{ticker_symbol}` endpoint to patch a specific stock prediction.
     * 
     * @return void
     */
    public function test_patch_stock_prediction_in_valid_format()
    {
        $stockPrediction = StockPrediction::factory()->create();

        $updatedStockPrediction = [
            'confidence' => 85.34,
            'predictions' => [
                'day 1' => 150.25,
                'day 2' => 155.00,
                'day 3' => 160.00,
                'day 4' => 165.00,
                'day 5' => 170.00,
                'day 6' => 175.00,
                'day 7' => 180.00,
                'day 8' => 185.00,
                'day 9' => 190.00,
                'day 10' => 195.00,
                'day 11' => 200.00,
                'day 12' => 205.00,
                'day 13' => 210.00,
                'day 14' => 215.00,
                'day 15' => 220.00,
                'day 16' => 225.00,
                'day 17' => 230.00,
                'day 18' => 235.00,
                'day 19' => 240.00,
                'day 20' => 245.00,
                'day 21' => 250.00,
                'day 22' => 255.00,
                'day 23' => 260.00,
                'day 24' => 265.00,
                'day 25' => 270.00,
                'day 26' => 275.00,
                'day 27' => 280.00,
                'day 28' => 285.00,
                'day 29' => 290.00,
                'day 30' => 295.00
            ]
        ];

        $response = $this->patchJson("/api/stockpredictions/{$stockPrediction->ticker_symbol}", $updatedStockPrediction);

        $response->assertStatus(200);

        $this->assertDatabaseHas('stock_predictions', [
            'ticker_symbol' => $stockPrediction->ticker_symbol,
            'confidence' => $updatedStockPrediction['confidence'],
            'predictions' => json_encode($updatedStockPrediction['predictions'])
        ]);
    }

    /**
     * Test `DELETE /api/stockpredictions/{ticker_symbol}` endpoint to delete a specific stock prediction.
     * 
     * @return void
     */
    public function test_delete_stock_prediction()
    {
        $stockPrediction = StockPrediction::factory()->create();

        $response = $this->deleteJson("/api/stockpredictions/{$stockPrediction->ticker_symbol}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('stock_predictions', [
            'ticker_symbol' => $stockPrediction->ticker_symbol
        ]);
    }
}
