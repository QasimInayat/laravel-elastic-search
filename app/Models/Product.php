<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Searchable;

    protected $fillable = [
        'name', 'category', 'brand', 'price', 'rating', 'in_stock',
    ];

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'category' => $this->category,
            'brand' => $this->brand,
            'price' => $this->price,
            'rating' => $this->rating,
            'in_stock' => $this->in_stock,
        ];
    }
}
