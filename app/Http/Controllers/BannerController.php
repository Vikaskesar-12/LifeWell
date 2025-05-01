<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Str;
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::orderBy('id','DESC')->paginate(10);
        return view('backend.banner.index',compact('banners'));
    }

    public function create()
    {
        return view('backend.banner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         =>  'string|required|max:50',
            'url'           =>  'url|required',
            'button_text'   =>  'string|nullable|max:35',
            'description'   =>  'string|nullable',
            'photo'         =>  'required',
            'position'      =>  'required|in:top,bottom',
            'status'        =>  'required|in:active,inactive',
        ]);

        if($request->hasfile('photo')){
            $image  = $request->file('photo');
            $path   = 'Images/banner/' . uniqid() . '.' . $image->extension();
            $image->move(public_path('Images/banner'), $path);
        }
        $data   =   $request->all();
        $slug   =   Str::slug($request->title);
        $count  =   Banner::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']   =   $slug;
        $data['photo']  =   $path;
        $status         =   Banner::create($data);
        if($status){
            request()->session()->flash('success','Banner successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding banner');
        }
        return redirect()->route('banner.index');
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
        $banner =   Banner::findOrFail($id);
        return view('backend.banner.edit',compact('banner'));
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
        $banner=Banner::findOrFail($id);
        $request->validate([
            'title'         =>'string|required|max:50',
            'url'           =>  'url|required',
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
        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner =   Banner::findOrFail($id);
        $status =   $banner->delete();
        if($status){
            request()->session()->flash('success','Banner successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting banner');
        }
        return redirect()->route('banner.index');
    }
}
