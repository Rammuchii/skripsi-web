<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['fruit', 'price'])]
class FruitPrice extends Model
{
    /**
     * Fruit classes whose price is editable by an admin.
     * "nonfruit" is intentionally excluded and stays fixed at 0.
     */
    public const EDITABLE_FRUITS = ['apple', 'banana', 'mango', 'orange', 'pineapple', 'strawberry'];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
        ];
    }
}
