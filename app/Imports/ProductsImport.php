<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        // Parent category
        $category = Category::where('title_en', $row['category'])
                            ->whereNull('parent_id') // ensure it's a parent
                            ->first();

        // Subcategory
        $subcategory = Category::where('title_en', $row['subcategory'])
                               ->whereNotNull('parent_id') // ensure it's a child
                               ->first();

        // Brand
        $brand = Brand::where('title', $row['brand'])->first();

        return new Product([
            'title_en'           => strip_tags($row['title_en']),
            'title_fr'           => strip_tags($row['title_fr']),
            'slug_en'            => Str::slug(strip_tags($row['title_en'])),
            'slug_fr'            => Str::slug(strip_tags($row['title_fr'])),
            'summary_en'         => strip_tags($row['summary_en']),
            'summary_fr'         => strip_tags($row['summary_fr']),
            'description_en'     => strip_tags($row['description_en']),
            'description_fr'     => strip_tags($row['description_fr']),
            'return_policy_en'   => strip_tags($row['return_policy_en']),
            'return_policy_fr'   => strip_tags($row['return_policy_fr']),
            'on_sale'            => strtolower($row['on_sale']) === 'yes',
            'top_rated'          => strtolower($row['top_rated']) === 'yes',
            'is_featured'        => strtolower($row['is_featured']) === 'yes',
            'deal_of_the_day'    => strtolower($row['deal_of_the_day']) === 'yes',
            'best_seller'        => strtolower($row['best_seller']) === 'yes',
            'cat_id'             => optional($category)->id,
            'child_cat_id'       => optional($subcategory)->id,
            'brand_id'           => optional($brand)->id,
            'price_type'         => $this->getPriceType($row['price_type']),
            'price'              => $row['price'],
            'old_price'          => $row['old_price'],
            'b2b_price'          => $row['b2b_price'],
            'b2c_price'          => $row['b2c_price'],
            'discount'           => $row['discount'],
            'discount_price'     => $row['discount_price'],
            'discount_start_date'=> $row['discount_start_date'],
            'discount_end_date'  => $row['discount_end_date'],
            'stock'              => $row['stock'],
            'size'               => $row['size'],
            'condition'          => $row['condition'],
            'status'             => strtolower($row['status']) == 'active' ? 'active' : 'inactive',
            'country_ability'         => $this->getCountryAbility($row['country_ability']),

        ]);
    }

    private function getPriceType($text)
    {
        $text = strtolower(trim($text));
        return match ($text) {
            'b2b' => '0',
            'b2c' => '1',
            'both' => '2',
            default => '2',
        };
    }
    
    
    private function getCountryAbility($text)
    {
        $text = strtolower(trim($text));
        return match ($text) {
            'india' => '0',
            'other' => '1',
            'all' => '2',
            default => '1',
        };
    }
}    

