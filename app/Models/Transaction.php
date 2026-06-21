<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'warung_id',
        'cashier_id',
        'transaction_code',
        'customer_name',
        'total_amount',
        'discount_amount',
        'tax_amount',
        'grand_total',
        'payment_method',
        'paid_amount',
        'change_amount',
        'status',
        'note',
        'cancelled_at',
        'cancel_reason'
    ];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
