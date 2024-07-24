<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockPredictionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ticker_symbol' => $this->ticker_symbol,
            'attributes' => [
                'company_name' => $this->company_name,
                'confidence' => $this->confidence,
                'predictions' => $this->predictions
            ]
        ];
    }
}
