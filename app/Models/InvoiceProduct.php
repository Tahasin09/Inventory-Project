<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceProduct extends Model
{
    protected $fillable = ['quantity', 'sale_price', 'user_id', 'product_id', 'invoice_id'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
