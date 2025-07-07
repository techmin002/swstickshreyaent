<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['product_id', 'closing_stock', 'opening_stock', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
