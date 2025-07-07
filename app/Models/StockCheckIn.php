<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockCheckIn extends Model
{
    protected $fillable = ['product_id', 'quantity', 'status', 'price', 'total'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
