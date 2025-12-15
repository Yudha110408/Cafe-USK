<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = ['transaction_id','product_id','quantity','price_at_sale','subtotal'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
