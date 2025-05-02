<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('backend.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('backend.pages.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|unique:pages,title',
            'slug' => 'nullable|unique:pages,slug',
            'description' => 'required',
        ]);
    
        try {
            $slug = $request->slug 
                ? \Str::slug($request->slug) 
                : \Str::slug($request->title);

            Page::create([
                'title' => $request->title,
                'slug' => $slug,
                
                'description' => $request->description,
                'meta_title' => $request->meta_title,
                'meta_keywords' => $request->meta_keywords,
                'meta_description' => $request->meta_description,
                'status' => $request->status ?? 0,
            ]);
    
            return redirect()->route('pages.index')->with('success', 'Page Created Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    



    
    public function edit(Page $page)
    {
        return view('backend.pages.edit', compact('page'));
    }





    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|unique:pages,title,' . $page->id,
            'slug' => 'nullable|unique:pages,slug,' . $page->id,
            'description' => 'required',
        ]);
    
        try {
            // Slug ko ya to user input se lo, ya title se generate karo
            $slug = $request->slug 
                ? \Str::slug($request->slug)
                : \Str::slug($request->title);
    
            $page->update([
                'title' => $request->title,
                'slug' => $slug,
                'description' => $request->description,
                'meta_title' => $request->meta_title,
                'meta_keywords' => $request->meta_keywords,
                'meta_description' => $request->meta_description,
                'status' => $request->status ?? 0,
            ]);
    
            return redirect()->route('pages.index')->with('success', 'Page Updated Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    



    




    public function destroy($id)
    {
        $discount = Page::findOrFail($id);
        $discount->delete();
        return redirect()->back()->with('success', 'Page code deleted.');
    }



}
