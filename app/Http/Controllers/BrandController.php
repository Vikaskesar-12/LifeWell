<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Brand,Category};
use Illuminate\Support\Str;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.brand.index');
    }

    public function displayData(Request $request){
            $perPage      = 10; 
            $currentPage  = $request->input('page', 1); 
            $skip         = ($currentPage - 1) * $perPage; 
            $total        = Brand::with('categories')->search($request)->count();
            $data         = Brand::with('categories')->search($request)->skip($skip)
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
        $category   =   Category::where('is_parent',0)->get();
        return view('backend.brand.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         =>  'string|required|unique:brands,title',
            'category_id'   =>  'required|array|min:1'
        ]);
        $data   =   $request->except('category_id');
        $slug   =   Str::slug($request->title);
        $count  =   Brand::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $status=Brand::create($data);
        if($status){
            $status->categories()->sync($request->category_id);
            request()->session()->flash('success','Brand successfully created');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('brand.index');
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
        $category   =   Category::where('is_parent',0)->get();
        $brand      =   Brand::with('categories')->find($id);
        if(!$brand){
            request()->session()->flash('error','Brand not found');
        }
        return view('backend.brand.edit',compact('category','brand'));
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
        $brand=Brand::find($id);
        $request->validate([
            'title'         =>  'string|required|unique:brands,title,' . $id,
            'category_id'   =>  'required|array|min:1'
        ]);
        $data=$request->except('category_id');
        
        $status=$brand->fill($data)->save();
        if($status){
            $brand->categories()->sync($request->category_id);
            request()->session()->flash('success','Brand successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand  =   Brand::find($id);
        if($brand){
            $status =   $brand->delete();
            if($status){
                request()->session()->flash('success','Brand successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('brand.index');
        }
        else{
            request()->session()->flash('error','Brand not found');
            return redirect()->back();
        }
    }
}
