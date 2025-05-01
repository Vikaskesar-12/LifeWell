<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Rules\HotSaleLimit;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.category.index');
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_cats=Category::where('is_parent',1)->orderBy('title_en','ASC')->get();
        return view('backend.category.create')->with('parent_cats',$parent_cats);
    }

    public function displayData(Request $request){
    //    dd('sdgdd');
        $perPage      = 10; 
        $currentPage  = $request->input('page', 1); 
        $skip         = ($currentPage - 1) * $perPage; 
        $total        = Category::search($request)->count();
        $data         = Category::with('parent_info')->search($request)->skip($skip)
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */




   


    public function store(Request $request)
    {
        // Validate inputs
        $request->validate([
            'title_en'   => 'string|required',      // English title validation
            'title_fr'   => 'string|required',      // French title validation
            'summary_en' => 'string|nullable',      // English summary validation
            'summary_fr' => 'string|nullable',      // French summary validation
            'price_filter' => 'nullable|numeric',
            'hot_sale' => ['nullable', new HotSaleLimit()],
            'photo' => 'required|image',            // Ensure the photo is an image
            'status' => 'required|in:active,inactive',
            'is_parent' => 'sometimes|in:1',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
    
        // Initialize paths for uploaded files
        $path = null;
        $iconPath = null;
        $banner = null;
    
        // Handling photo upload
        if ($request->hasfile('photo')) {
            $image = $request->file('photo');
            $path = 'Images/category/' . uniqid() . '.' . $image->extension();
            $image->move(public_path('Images/category'), $path);
        }
    
        // Handling banner upload
        if ($request->hasfile('banner')) {
            $image = $request->file('banner');
            $banner = 'Images/category/' . uniqid() . '.' . $image->extension();
            $image->move(public_path('Images/category'), $banner);
        }
    
        // Handling icon upload
        if ($request->hasfile('icon')) {
            $image = $request->file('icon');
            $iconPath = 'Images/category/' . uniqid() . '.' . $image->extension();
            $image->move(public_path('Images/category'), $iconPath);
        }
    
        // Generate slugs for both English and French titles
        $slug_en = Str::slug($request->title_en);  // Slug for English title
        $slug_fr = Str::slug($request->title_fr);  // Slug for French title
    
        // Ensure unique slugs by checking their existence in the database
        $count_en = Category::where('slug_en', $slug_en)->count();
        $count_fr = Category::where('slug_fr', $slug_fr)->count();
    
        if ($count_en > 0) {
            $slug_en = $slug_en . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        if ($count_fr > 0) {
            $slug_fr = $slug_fr . '-' . date('ymdis') . '-' . rand(0, 999);
        }
    
        // Prepare data to insert into the database
        $data = $request->all();
        $data['slug_en'] = $slug_en;
        $data['slug_fr'] = $slug_fr;
        $data['is_parent'] = $request->input('is_parent', 0);
        $data['hot_sale'] = $request->input('hot_sale', 0);
        $data['photo'] = $path;
        $data['category_banner'] = $banner;
        $data['icon'] = $iconPath;
        $data['title_en'] = $request->title_en;
        $data['title_fr'] = $request->title_fr;
        $data['summary_en'] = $request->summary_en;
        $data['summary_fr'] = $request->summary_fr;
    
        // Insert data into the database
        $status = Category::create($data);
    
        // Flash message based on success or failure
        if ($status) {
            request()->session()->flash('success', 'Category successfully added');
        } else {
            request()->session()->flash('error', 'Error occurred, Please try again!');
        }
    
        // Redirect to the category index page
        return redirect()->route('category.index');
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
        $parent_cats    =   Category::where('is_parent',1)->get();
        $category       =   Category::findOrFail($id);
        return view('backend.category.edit',compact('parent_cats','category'));
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
        // Find the category by its ID
        $category = Category::findOrFail($id);
    
        // Validate inputs
        $request->validate([
            'title_en'   => 'string|required',   // English title validation
            'title_fr'   => 'string|required',   // French title validation
            'summary_en' => 'string|nullable',   // English summary validation
            'summary_fr' => 'string|nullable',   // French summary validation
            'hot_sale'   => ['nullable', new HotSaleLimit($id)],  // Hot Sale validation
            'status'     => 'required|in:active,inactive',   // Status validation
            'is_parent'  => 'sometimes|in:1',    // Parent category flag
            'parent_id'  => 'nullable|exists:categories,id',  // Parent category ID validation
        ]);
    
        // Initialize paths for uploaded files
        $path = $category->photo;  // Default photo path if no new photo is uploaded
        $iconPath = $category->icon;  // Default icon path
        $banner = $category->category_banner;  // Default banner path
    
        // Handling photo upload
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $path = 'Images/category/' . uniqid() . '.' . $image->extension();
            $image->move(public_path('Images/category'), $path);
        }
    
        // Handling icon upload
        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $iconPath = 'Images/category/' . uniqid() . '.' . $image->extension();
            $image->move(public_path('Images/category'), $iconPath);
        }
    
        // Handling banner upload
        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $banner = 'Images/category/' . uniqid() . '.' . $image->extension();
            $image->move(public_path('Images/category'), $banner);
        }
    
        // Prepare data to update
        $data = $request->all();
        $data['photo'] = $path;
        $data['category_banner'] = $banner;
        $data['icon'] = $iconPath;
        $data['is_parent'] = $request->input('is_parent', 0);
        $data['hot_sale'] = $request->input('hot_sale', 0);
    
        // Update the category
        $status = $category->fill($data)->save();
    
        // Flash message based on success or failure
        if ($status) {
            session()->flash('success', 'Category successfully updated');
        } else {
            session()->flash('error', 'Error occurred, Please try again!');
        }
    
        // Redirect back to the category index page
        return redirect()->route('category.index');
    }
    





    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category       =   Category::findOrFail($id);
        $child_cat_id   =   Category::where('parent_id',$id)->pluck('id');
        $status=$category->delete();
        
        if($status){
            if(count($child_cat_id)>0){
                Category::shiftChild($child_cat_id);
            }
            request()->session()->flash('success','Category successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting category');
        }
        return redirect()->route('category.index');
    }

    public function getChildByParent(Request $request){
        $category   =   Category::findOrFail($request->id);
        $child_cat  =   Category::getChildByParentID($request->id);
        if(count($child_cat)<=0){
            return response()->json(['status'=>false,'msg'=>'','data'=>null]);
        }
        else{
            return response()->json(['status'=>true,'msg'=>'','data'=>$child_cat]);
        }
    }
}
