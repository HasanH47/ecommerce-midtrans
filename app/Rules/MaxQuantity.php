<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxQuantity implements ValidationRule
{
    protected $productId;

    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = Product::find($this->productId);

        if ($product && $value > $product->stock) {
            $fail('Kuantitas tidak boleh melebihi stok produk yang tersedia.');
        }
    }
}
