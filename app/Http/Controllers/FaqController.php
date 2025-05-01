<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Faq,Specification};

class FaqController extends Controller
{
    public function index()
    {
        return view('backend.faq.index');
    }

    public function displayData(Request $request){
            $perPage      = 10; 
            $currentPage  = $request->input('page', 1); 
            $skip         = ($currentPage - 1) * $perPage; 
            $total        = Faq::search($request)->count();
            $data         = Faq::search($request)->skip($skip)
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
        return view('backend.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question'=>'string|required',
            'answer'=>'string|required',
        ]);
        $data = Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
        if($data){
            request()->session()->flash('success','Faq successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('faq.index');


    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faq=Faq::findOrFail($id);
        return view('backend.faq.edit',compact('faq'));
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
        
        $faq=faq::findOrFail($id);
        $request->validate([
            'question'=>'string|required',
            'answer'=>'string|required',
        ]);
           $status =  $faq->update([
                    'question' => $request->question,
                    'answer' => $request->answer,
                ]);
        if($status){
            request()->session()->flash('success','faq successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('faq.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq=Faq::findOrFail($id);
        $status=$faq->delete();
        
        if($status){
            request()->session()->flash('success','Category successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting category');
        }
        return redirect()->route('faq.index');
    }

   
}
