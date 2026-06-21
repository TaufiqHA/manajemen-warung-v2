<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'product_name',
        'unit_price',
        'quantity',
        'served_qty',
        'discount',
        'subtotal',
        'catatan'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
