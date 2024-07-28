<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
