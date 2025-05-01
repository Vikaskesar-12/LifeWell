<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product,ProductSpecification,ProductImage,ProductVariant};
use App\Models\Category;
use App\Models\Brand;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::getAllProduct();
        return view('backend.product.index',compact('products'));
    }

    public function displayData(Request $request){
            $perPage      = 10; 
            $currentPage  = $request->input('page', 1); 
            $skip         = ($currentPage - 1) * $perPage; 
            $total        = Product::count();
            $data         = Product::with('cat_info','sub_cat_info','brand')->search($request)->skip($skip)
                                ->take($perPage)
                                ->get();
            $totalPages = ceil($total / $perPage);
            return response()->json([
                'status'        => true,
                'data'          => $data,
                'total'         => $total,
                'currentPage'   => $currentPage,
                'totalPages'    => $totalPages,
                'perPage'       => $perPage
            ]);
    
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand      =   Brand::get();
        $category   =   Category::where('is_parent',1)->get();
        return view('backend.product.create')->with('categories',$category)->with('brands',$brand);

    }

    public function brands(Request $request){
        $category   =   Category::with('brands')->where('id',$request->id)->first();
        $brand      =   $category->brands;
        if(count($brand)<=0){
            return response()->json(['status'=>false,'msg'=>'','data'=>null]);
        }
        else{
            return response()->json(['status'=>true,'msg'=>'','data'=>$brand]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */






public function store(Request $request)
{
    // Debugging the request to see all inputs
    // dd($request->all());

    // Validate the request
    $request->validate([
        'title_en'         => 'required|string',
        'title_fr'         => 'nullable|string',
        'slug_en'          => 'nullable|string',
        'slug_fr'          => 'nullable|string',
        'summary_en'       => 'required|string',
        'summary_fr'       => 'nullable|string',
        'description_en'   => 'nullable|string',
        'description_fr'   => 'nullable|string',
        'return_policy_en' => 'nullable|string',
        'return_policy_fr' => 'nullable|string',
        'stock'            => 'required|numeric',
        'cat_id'           => 'required|exists:categories,id',
        'brand_id'         => 'required|exists:brands,id',
        'child_cat_id'     => 'nullable|exists:categories,id',
        'is_featured'      => 'sometimes|in:1',
        'status'           => 'required|in:active,inactive',
        'condition'        => 'required|in:default,new,hot',
        'specification.*'  => 'required',
        'price'            => 'required|numeric',
        'discount'         => 'nullable|numeric',
        'variant_title'    => 'string|required',
        'price_type'       => 'required|in:0,1,2',  // Validate price_type (0: B2B, 1: B2C, 2: Both)
        'b2b_price'        => 'nullable|numeric|required_if:price_type,0',  // B2B price required only if price_type is 0
        'b2c_price'        => 'nullable|numeric|required_if:price_type,1',  // B2C price required only if price_type is 1
        'country_ability'  => 'required|in:0,1,2',  // Validate country_ability (0: India, 1: Other, 2: All)
        'discount_price' => 'nullable|numeric|min:0',
        'discount_start_date' => 'nullable|date|before_or_equal:discount_end_date',
        'discount_end_date' => 'nullable|date|after_or_equal:discount_start_date',
        'minimum_order_quantity' => 'nullable|numeric|min:0',

        


    ]);

    // Generate slugs for the product
    $slug_en = Str::slug($request->title_en);
    $slug_fr = $request->title_fr ? Str::slug($request->title_fr) : null;

    // Ensure unique slugs
    $slug_en = $this->generateUniqueSlug($slug_en, 'slug_en');
    if ($slug_fr) {
        $slug_fr = $this->generateUniqueSlug($slug_fr, 'slug_fr');
    }

    // Create product
    $product = Product::create([
        'title_en'        => $request->title_en,
        'title_fr'        => $request->title_fr,
        'slug_en'         => $slug_en,
        'slug_fr'         => $slug_fr,
        'summary_en'      => $request->summary_en,
        'summary_fr'      => $request->summary_fr,
        'description_en'  => $request->description_en,
        'description_fr'  => $request->description_fr,
        'return_policy_en'=> $request->return_policy_en,
        'return_policy_fr'=> $request->return_policy_fr,
        'is_featured'     => $request->is_featured,
        'cat_id'          => $request->cat_id,
        'child_cat_id'    => $request->child_cat_id,
        'brand_id'        => $request->brand_id,
        'price_type'      => $request->price_type,
        'b2b_price'       => $request->b2b_price,
        'b2c_price'       => $request->b2c_price,
        'country_ability' => $request->country_ability,
        'discount_price' => $request->discount_price,
        'discount_start_date' => $request->discount_start_date,
        'discount_end_date' => $request->discount_end_date,
        'minimum_order_quantity' => $request->minimum_order_quantity,

        
    ]);


    // Create product variant
    $variantSlug = Str::slug($request->variant_title);
    $variant = ProductVariant::create([
        'title'           => $request->variant_title,
        'collection'      => $request->collection,
        'discount'        => $request->discount,
        'base_price'      => $request->base_price,
        'price'           => $request->price,
        'stock'           => $request->stock,
        'status'          => $request->variant_status,
        'product_id'      => $product->id,
        'slug'            => $variantSlug


        
    ]);

    // Add specifications if available
    if (!empty($request->specification)) {
        foreach ($request->specification as $specification) {
            ProductSpecification::create([
                'product_id' => $variant->id,
                'name' => $specification,
                'type' => $request->$specification ?? '',  // Add type dynamically based on specification name
            ]);
        }
    }

    // Handle product image upload if present
    if ($request->hasFile('photo')) {
        foreach ($request->file('photo') as $image) {
            if ($image->isValid()) {
                $path = 'Images/product/' . uniqid() . '.' . $image->extension();
                $image->move(public_path('Images/product/'), $path);
                ProductImage::create([
                    'product_id' => $variant->id,
                    'image' => $path
                ]);
            }
        }
    }

    // Flash success message
    session()->flash('success', 'Product successfully added.');

    // Redirect back to the product index page
    return redirect()->route('product.index');
}





/**
 * Helper function to generate unique slug
 */
private function generateUniqueSlug($slug, $column)
{
    // Check if the slug already exists
    $count = Product::where($column, $slug)->count();
    if ($count > 0) {
        return $slug . '-' . date('ymdis') . '-' . rand(0, 999);
    }
    return $slug;
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brands     = Brand::all();  // Or use get() as before
        $product    = Product::with('productSpecification', 'productImages')->findOrFail($id);
        $categories = Category::where('is_parent', 1)->where('status', 1)->get();
        $items      = Product::where('id', $id)->get();
    
        return view('backend.product.edit', compact('product', 'brands', 'categories', 'items'));
    }
    
    public function salesUpdate(Request $request)
    {
        $product    =   Product::find($request->id);
        $product->update([
            'on_sale'         => $request->status ?? $product->on_sale,
            'deal_of_the_day' => $request->today_deal ?? $product->deal_of_the_day,
        ]);
        if($product)
            return response()->json(['status' => true]);
        else
            return response()->json(['status' => false]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product=Product::findOrFail($id);
        $request->validate([
            'title_en'         => 'required|string',
            'title_fr'         => 'nullable|string',
            'slug_en'          => 'nullable|string',
            'slug_fr'          => 'nullable|string',
            'summary_en'       => 'required|string',
            'summary_fr'       => 'nullable|string',
            'description_en'   => 'nullable|string',
            'description_fr'   => 'nullable|string',
            'return_policy_en' => 'nullable|string',
            'return_policy_fr' => 'nullable|string',
            'cat_id'        =>  'required|exists:categories,id',
            'child_cat_id'  =>  'nullable|exists:categories,id',
            'is_featured'   =>  'sometimes|in:1',
            'brand_id'      =>  'nullable|exists:brands,id',
            'status'        =>  'required|in:active,inactive',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_start_date' => 'nullable|date|before_or_equal:discount_end_date',
            'discount_end_date' => 'nullable|date|after_or_equal:discount_start_date',
            'minimum_order_quantity' => 'nullable|numeric|min:0',

            
        ]);

        $data                   =   $request->all();
        $data['top_rated']      =   $request->input('top_rated',0);
        $data['best_seller']    =   $request->input('best_seller',0);
      
        $status=$product->fill($data)->save();
        if($status){
            request()->session()->flash('success','Product Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('product.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        $status=$product->delete();
        
        if($status){
            request()->session()->flash('success','Product successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting product');
        }
        return redirect()->route('product.index');
    }

    public function deleteImage(Request $request){
        $data = ProductImage::where('id',$request->id)->delete();
        if($data)
            return response()->json(['status' => true]);
        else
            return redirect()->back()->with('error','somthing went wrong');
    }



    public function export()
{
    return Excel::download(new ProductsExport, 'products.xlsx');
}



public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv'
    ]);

    Excel::import(new ProductsImport, $request->file('file'));

    return back()->with('success', 'Products imported successfully!');
}




    
}
