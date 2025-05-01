<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category,Specification};

class SpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return view('backend.specification.index');
    }

    public function displayData(Request $request){
            $perPage      = 10; 
            $currentPage  = $request->input('page', 1); 
            $skip         = ($currentPage - 1) * $perPage; 
            $total        = Specification::search($request)->count();
            $data         = Specification::with('category')->search($request)->skip($skip)
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
    // public function create()
    // {
    //     $parent_cats=Category::where('is_parent',0)->orderBy('title_en','ASC')->get();
    //     return view('backend.specification.create')->with('parent_cats',$parent_cats);
    // }

    public function create()
{
    // Get the browser's preferred language
    $locale = app()->getLocale(); // This will give 'en' or 'fr'
    // dd($locale);  // Check the browser's current locale

    // Fetch categories based on the browser language
    $parent_cats = Category::where('is_parent', 0)
                            ->orderBy('title_' . $locale, 'ASC')
                            ->get();

    return view('backend.specification.create', compact('parent_cats'));
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
            'category_id'=>'string|required',
        ]);
        foreach($request->name as $key => $name){
            $data[] = Specification::create([
                'category_id' => $request->category_id,
                'name' => $name,
                'type' => implode(',',$request->type[$key])
            ]);
        }
        if(count($data) > 0){
            request()->session()->flash('success','specification successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('specification.index');


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
        $parent_cats=Category::where('is_parent',0)->get();
        $specification=Specification::findOrFail($id);
        return view('backend.specification.edit')->with('specification',$specification)->with('parent_cats',$parent_cats);
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
        
        $specification=specification::findOrFail($id);
        $request->validate([
           'category_id'=>'string|required',
        ]);
           $status =  $specification->update([
                    'category_id' => $request->category_id,
                    'name' => $request->name,
                    'type' => implode(',',$request->type)
                ]);
        if($status){
            request()->session()->flash('success','specification successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('specification.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $specification=specification::findOrFail($id);
        $status=$specification->delete();
        
        if($status){
            request()->session()->flash('success','Category successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting category');
        }
        return redirect()->route('specification.index');
    }

    public function getSpecification(Request $request){
        $data = specification::where('category_id',$request->id)->get()->map(function($item){
            $item->type = explode(',',$item->type);
            return $item;
        })->toArray();
        if(count($data)<=0){
            return response()->json(['status'=>false,'msg'=>'','data'=>null]);
        }
        else{
            return response()->json(['status'=>true,'msg'=>'','data'=>$data]);
        }
    }
}
