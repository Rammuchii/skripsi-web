<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['fruit', 'confidence', 'weight', 'price_per_kg', 'total_price', 'image_path'])]
class Prediction extends Model
{
    protected function casts(): array
    {
        return [
            'confidence' => 'float',
            'weight' => 'float',
            'price_per_kg' => 'integer',
            'total_price' => 'float',
        ];
    }
}
