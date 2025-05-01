<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;

class CollectionController extends Controller
{
    public function index()
    {
        return view('backend.collection.index');
    }

    public function displayData(Request $request){
        $perPage      = 10; 
        $currentPage  = $request->input('page', 1); 
        $skip         = ($currentPage - 1) * $perPage; 
        $total        = Collection::search($request)->count();
        $data         = Collection::search($request)->skip($skip)
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

    public function create()
    {
        return view('backend.collection.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     =>'string|required',
            'status'    =>'required|in:active,inactive',
        ]);
        $status             =   Collection::create($request->all());
        if($status){
            request()->session()->flash('success','collction successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('collection.index');
    }

    public function edit($id)
    {
        $collection       =   Collection::findOrFail($id);
        return view('backend.collection.edit',compact('collection'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'     =>'string|required',
            'status'    =>'required|in:active,inactive',
        ]);
        $status             =   Collection::where('id',$id)->update($request->all());
        if($status){
            request()->session()->flash('success','collction successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('collection.index');
    }

    public function destroy($id)
    {
        $category       =   Collection::findOrFail($id);
        $status=$category->delete();
        if($status){
            request()->session()->flash('success','collction successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting category');
        }
        return redirect()->route('collection.index');
    }
}
