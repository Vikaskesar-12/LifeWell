<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $products = Product::with(['cat_info', 'sub_cat_info', 'brand'])->get();

        return $products->map(function ($product, $index) {
            return [
                'S.N.'                => $index + 1,
                'Title EN'            => strip_tags($product->title_en),
                'Title FR'            => strip_tags($product->title_fr),
                'Slug EN'             => $product->slug_en,
                'Slug FR'             => $product->slug_fr,
                'Summary EN'          => strip_tags($product->summary_en),
                'Summary FR'          => strip_tags($product->summary_fr),
                'Description EN'      => strip_tags($product->description_en),
                'Description FR'      => strip_tags($product->description_fr),
                'Return Policy EN'    => strip_tags($product->return_policy_en),
                'Return Policy FR'    => strip_tags($product->return_policy_fr),
                'On Sale'             => $product->on_sale ? 'Yes' : 'No',
                'Top Rated'           => $product->top_rated ? 'Yes' : 'No',
                'Is Featured'         => $product->is_featured ? 'Yes' : 'No',
                'Deal of the Day'     => $product->deal_of_the_day ? 'Yes' : 'No',
                'Best Seller'         => $product->best_seller ? 'Yes' : 'No',
               'Category'    => optional($product->cat_info)->title_en ?: 'No Category',
               'Subcategory' => optional($product->sub_cat_info)->title_en ?: 'No Subcategory',

               'Brand'       => optional($product->brand)->title,
               'Price Type' => $product->price_type_text,  // Will output 'B2B', 'B2C', 'Both' based on the price_type value

                'Price'               => $product->price,
                'Old Price'           => $product->old_price,
                'B2B Price'           => $product->b2b_price,
                'B2C Price'           => $product->b2c_price,
                'Discount'            => $product->discount,
                'Discount Price'      => $product->discount_price,
                'Discount Start Date' => $product->discount_start_date,
                'Discount End Date'   => $product->discount_end_date,
                'Stock'               => $product->stock,
                'Size'                => $product->size,
                'Condition'           => $product->condition,
                'Photo'               => $product->photo,
                'Status'              => $product->status,
                'Country Ability'     => $product->country_ability_text,
                'Created At'          => $product->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'S.N.',
            'Title EN',
            'Title FR',
            'Slug EN',
            'Slug FR',
            'Summary EN',
            'Summary FR',
            'Description EN',
            'Description FR',
            'Return Policy EN',
            'Return Policy FR',
            'On Sale',
            'Top Rated',
            'Is Featured',
            'Deal of the Day',
            'Best Seller',
            'Category',
            'Subcategory',
            'Brand',
            'Price Type',
            'Price',
            'Old Price',
            'B2B Price',
            'B2C Price',
            'Discount',
            'Discount Price',
            'Discount Start Date',
            'Discount End Date',
            'Stock',
            'Size',
            'Condition',
            'Photo',
            'Status',
            'Country Ability',
            'Created At',
        ];
    }
}
