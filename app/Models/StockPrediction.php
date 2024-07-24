<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockPrediction extends Model
{
    use HasFactory;

    protected $primaryKey = 'ticker_symbol'; // important for UPDATE and DELETE to work

    protected $keyType = 'string';

    public $timestamps = false;

    public $incrementing = false;

    /**
     * The attributes of Stock Prediction
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'ticker_symbol',
        'company_name',
        'confidence',
        'predictions'
    ];

    /**
     * The attributes of Stock Prediction casted
     * 
     * @var array<string, string>
     */
    protected $casts = [
        'predictions' => 'array'
    ];
}
