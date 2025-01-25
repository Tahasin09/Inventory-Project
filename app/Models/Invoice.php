<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Pest\ArchPresets\Custom;

class Invoice extends Model
{
    protected $fillable = ['total', 'discount', 'vat', 'payable', 'user_id', 'customer_id'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
