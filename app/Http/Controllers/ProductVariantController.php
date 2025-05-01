<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ProductVariant,Product,ProductSpecification,ProductImage,Collection};
use Illuminate\Support\Str;

class ProductVariantController extends Controller
{
    public function index(){
        return view('backend.product.variants.index');
    }

    public function displayData(Request $request){
        $perPage      = 10; 
        $currentPage  = $request->input('page', 1); 
        $skip         = ($currentPage - 1) * $perPage; 
        $total        = ProductVariant::where('product_id',$request->id)->count();
        $data         = ProductVariant::where('product_id',$request->id)->with('productSpecification','productImage')->search($request)->skip($skip)
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

    public function create($id){
        $product    = Product::find($id);
        $collections = Collection::whereStatus('active')->get();
        return view('backend.product.variants.create',compact('product','collections'));
    }

    public function store(Request $request){
        
        $request->validate([
            'specification'     =>  'required',
            'collection'        =>  'required',
            'price'             =>  'required|numeric',
            'discount'          =>  'nullable|numeric'
        ]);
       
        $exist = ProductVariant::where('product_id',$request->product_id);
        foreach($request->specification as $key => $name){
            $exists = $exist->whereHas('productSpecification',function($query) use($request,$name){
                $query->where('name',$name)->where('type',$request->$name);
            })->get();
        }
        
        if(isset($exists) && count($exists) > 0){
            $errors[] = 'This variant already exist';
        }
        if (!empty($errors)) {
            return back()->withErrors([
                'specification' => implode(' ', $errors),
            ])->withInput();
        }
        $variantslug    =   Str::slug($request->title);
        $variant        =   ProductVariant::create([
                                'title'         =>  $request->title,
                                'discount'      =>  $request->discount,
                                'base_price'    =>  $request->base_price,
                                'price'         =>  $request->price,
                                'stock'         =>  $request->stock,
                                'status'        =>  $request->variant_status,
                                'product_id'    =>  $request->product_id,
                                'slug'          =>  $variantslug
                            ]);
        if($variant){
            $variant->collection()->sync($request->collection);
            if(!empty($request->specification)){
                foreach($request->specification as $key => $name){
                    ProductSpecification::create([
                        'product_id'    => $variant->id,
                        'name' => $name,
                        'type' => isset($request->$name) ? $request->$name : '',
                    ]);
                }
            }
            if(!empty($request->photo)){
                foreach ($request->photo as $image) {
                    if ($image->isValid()) {
                        $path = 'Images/product/' . uniqid() . '.' . $image->extension();
                        $image->move(public_path('Images/product/'), $path);
                    }
                    ProductImage::create([
                        'product_id' => $variant->id,
                        'image'       => $path
                    ]);
                }
            }
            request()->session()->flash('success','Product Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('product-variant',$request->product_id);
    }

    public function edit($product_id,$variant_id){
        $variant = ProductVariant::with('productSpecification','productImage')->find($variant_id);
        return view('backend.product.variants.edit',compact('variant'));
    }

    public function update(Request $request){
        $request->validate([
            'title'             =>  'required',
            'collection'        =>  'required|in:default,new,hot',
            'specification.*'   =>  'required',
            'price'             =>  'required|numeric',
            'discount'          =>  'nullable|numeric',
            'variant_id'        =>  'required'
        ]);
        $exists = [];
        foreach($request->specification as $key => $name){
            $exist =ProductVariant::where('id','!=',$request->variant_id)->
                    whereHas('productSpecification',function($query) use($request,$name){
                        $query->where('name',$name)->where('type',$request->$name);
                    })->where('product_id',$request->product_id)->first();
            $exists[] = $exist ? true : false;
        }
        if(!in_array(false,$exists)){
            request()->session()->flash('error','this variant already exist');
            return redirect()->back();
        }
        $variantslug   =   Str::slug($request->title);
        $variant    =   ProductVariant::find($request->variant_id)->update([
                            'title'         =>  $request->title,
                            'collection'    =>  $request->collection,
                            'discount'      =>  $request->discount,
                            'base_price'    =>  $request->base_price,
                            'price'         =>  $request->price,
                            'stock'         =>  $request->stock,
                            'status'        =>  $request->variant_status,
                            'slug'          =>  $variantslug
                        ]);
        if($variant){
            if(!empty($request->specification)){
                foreach($request->specification as $key => $name){
                    ProductSpecification::where('product_id',$request->variant_id)
                    ->where('name',$name)->update([
                        'type' => isset($request->$name) ? $request->$name : '',
                    ]);
                }
            }
            if(!empty($request->photo)){
                foreach ($request->photo as $image) {
                    if ($image->isValid()) {
                        $path = 'Images/product/' . uniqid() . '.' . $image->extension();
                        $image->move(public_path('Images/product/'), $path);
                    }
                    ProductImage::create([
                        'product_id' => $request->variant_id,
                        'image'       => $path
                    ]);
                }
            }
            request()->session()->flash('success','Product Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('product-variant',$request->product_id);
    }

    public function delete($id)
    {
        $product=ProductVariant::findOrFail($id);
        $status=$product->delete();
        
        if($status){
            request()->session()->flash('success','Product successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting product');
        }
        return redirect()->route('product-variant',$product->product_id);
    }
}
