<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOutProduct extends Model
{
    protected $fillable = ['stock_out_id', 'product_id', 'quantity', 'price', 'total'];

    public function stockOut()
    {
        return $this->belongsTo(StockOut::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
