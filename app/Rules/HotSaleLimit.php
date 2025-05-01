<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Category;

class HotSaleLimit implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $productId;

    // Constructor to receive the product ID
    public function __construct($productId = null)
    {
        $this->productId = $productId;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value) {
            // Count the current hot sale products
            $hotSaleCount = Category::where('hot_sale',1) ->when($this->productId, function ($query) {
                return $query->where('id', '!=', $this->productId);
            })->count();
            // Check if there are already 3 or more hot sale products
            if ($hotSaleCount >= 3) {
                $fail("You cannot have more than 3 hot sale products.");
            }
        }
    }
}
