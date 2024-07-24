<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockPredictionRequest;
use App\Http\Requests\UpdateStockPredictionRequest;
use App\Http\Resources\StockPredictionResource;
use App\Models\StockPrediction;

class StockPredictionController extends Controller
{
    /**
     * Display a listing of the Stock Predictions.
     * 
     * @return \App\Http\Resources\StockPredictionResource
     */
    public function index()
    {
        return response()->json([
            'data' => StockPredictionResource::collection(StockPrediction::all())
        ], 200);
    }

    /**
     * Display the specified Stock Prediction using its corresponding Ticker Symbol.
     * 
     * @param string $ticker_symbol
     * @return \App\Http\Resources\StockPredictionResource
     */
    public function show(string $tickerSymbol)
    {
        $stockPrediction = StockPrediction::where('ticker_symbol', $tickerSymbol)->first();

        if (!$stockPrediction) {
            return response()->json(['message' => ($tickerSymbol . ' Stock not found.')], 404);
        }

        return response()->json([
            'data' => [
                'ticker_symbol' => $stockPrediction->ticker_symbol,
                'attributes' => [
                    'company_name' => $stockPrediction->company_name,
                    'confidence' => $stockPrediction->confidence,
                    'predictions' => $stockPrediction->predictions
                ]
            ]
        ], 200);
    }

    /**
     * Store a newly created Stock Prediction in storage.
     * 
     * @param \App\Http\Resources\StockPredictionResource $request
     * @return \App\Http\Resources\StockPredictionResource
     */
    public function store(StoreStockPredictionRequest $request)
    {
        $request->validated($request->all());

        $stockPrediction = StockPrediction::create([
            'ticker_symbol' => $request->ticker_symbol,
            'company_name' => $request->company_name,
            'confidence' => $request->confidence,
            'predictions' => $request->predictions
        ]);

        return response()->json([
            'message' => $stockPrediction->ticker_symbol . ' was created successfully.',
            'data' => new StockPredictionResource($stockPrediction)
        ], 201); 
    }

    /**
     * Update the specific Stock Prediction using its corresponding Ticker Symbol.
     * 
     * @param \App\Http\Requests\UpdateStockPredictionRequest $request
     * @param string $tickerSymbol
     * 
     * @return \App\Http\Resources\StockPredictionResource | \Illuminate\Http\Response
     */
    public function update(UpdateStockPredictionRequest $request, string $tickerSymbol)
    {
        $stockPrediction = StockPrediction::where('ticker_symbol', $tickerSymbol)->first();

        if (!$stockPrediction) {
            return response()->json(['message' => ($tickerSymbol . 'Stock not found.')], 404);
        }

        $stockPrediction->update($request->validated());

        return response()->json([
            'message' => $stockPrediction->ticker_symbol . ' was updated successfully.',
            'data' => new StockPredictionResource($stockPrediction)
        ], 200);
    }

    /**
     * Remove the specified Stock Prediction from storage using its corresponding Ticker Symbol.
     * 
     * @param string $tickerSymbol
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $tickerSymbol)
    {
        $stockPrediction = StockPrediction::where('ticker_symbol', $tickerSymbol)->first();

        if (!$stockPrediction) {
            return response()->json(['message' => 'Stock not found.'], 404);
        }

        $stockPrediction->delete();

        return response($tickerSymbol . ' Stock Deleted.', 200);
    }
}
