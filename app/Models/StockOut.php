<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $fillable = ['customer_id', 'total', ];

    public function products()
    {
        return $this->hasMany(StockOutProduct::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
