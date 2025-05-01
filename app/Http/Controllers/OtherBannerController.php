<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{OtherBanner,Category};
use Illuminate\Support\Str;

class OtherBannerController extends Controller
{
    public function index()
    {
        $banners = OtherBanner::orderBy('id','DESC')->paginate(10);
        return view('backend.other_banner.index',compact('banners'));
    }

    public function create()
    {
        $parent_cats=Category::where('is_parent',1)->orderBy('title','ASC')->get();
        return view('backend.other_banner.create',compact('parent_cats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         =>  'string|required|max:50',
            'url'           =>  'url|required',
            'category_id'   =>  'required|unique:other_banners,category_id,',
            'button_text'   =>  'string|nullable|max:35',
            'description'   =>  'string|nullable',
            'photo'         =>  'required',
            'status'        =>  'required|in:active,inactive',
        ]);

        if($request->hasfile('photo')){
            $image  = $request->file('photo');
            $path   = 'Images/banner/' . uniqid() . '.' . $image->extension();
            $image->move(public_path('Images/banner'), $path);
        }
        $data   =   $request->all();
        $slug   =   Str::slug($request->title);
        $count  =   OtherBanner::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']   =   $slug;
        $data['photo']  =   $path;
        $status         =   OtherBanner::create($data);
        if($status){
            request()->session()->flash('success','Banner successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding banner');
        }
        return redirect()->route('banners.index');
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
        $banner =   OtherBanner::findOrFail($id);
        $parent_cats=Category::where('is_parent',1)->orderBy('title','ASC')->get();
        return view('backend.other_banner.edit',compact('banner','parent_cats'));
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
        $banner=OtherBanner::findOrFail($id);
        $request->validate([
            'title'         =>'string|required|max:50',
            'url'           =>  'url|required',
            'category_id'   =>  'required|unique:other_banners,category_id,' . $id,
            'button_text'   =>  'string|nullable|max:35',
            'description'   =>'string|nullable',
            'status'        =>'required|in:active,inactive',
        ]);
        if($request->hasfile('photo')){
            $image  = $request->file('photo');
            $path   = 'Images/banner/' . uniqid() . '.' . $image->extension();
            $image->move(public_path('Images/banner'), $path);
        }else{
            $path   = $banner->photo;
        }
        $data           =   $request->all();
        $data['photo']  =   $path;
        $status         =   $banner->fill($data)->save();
        if($status){
            request()->session()->flash('success','Banner successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating banner');
        }
        return redirect()->route('banners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner =   OtherBanner::findOrFail($id);
        $status =   $banner->delete();
        if($status){
            request()->session()->flash('success','Banner successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting banner');
        }
        return redirect()->route('banners.index');
    }
}
