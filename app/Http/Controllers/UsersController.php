<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::orderBy('id','ASC')->where('role','user')->paginate(10);
        return view('backend.users.index',compact('users'));
    }

    public function displayData(Request $request){
        //    dd('sdgdd');
            $perPage      = 10; 
            $currentPage  = $request->input('page', 1); 
            $skip         = ($currentPage - 1) * $perPage; 
            $total        = User::orderBy('id','ASC')->where('role','user')->search($request)->count();
            $data         = User::orderBy('id','ASC')->where('role','user')->search($request)->skip($skip)
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
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
        [
            'name'      =>  'string|required|max:30',
            'email'     =>  'string|required|unique:users',
            'password'  =>  'string|required',
            'role'      =>  'required|in:admin,user',
            'status'    =>  'required|in:active,inactive',
            'photo'     =>  'nullable',
        ]);
        $path = null;
        if($request->hasfile('photo')){
            $image  = $request->file('photo');
            $path   = 'Images/user/' . uniqid() . '.' . $image->extension();
            $image->move(public_path('Images/user'), $path);
        }
        $data=$request->all();
        $data['password']=Hash::make($request->password);
        $data['photo']      =   $path;
        // dd($data);
        $status=User::create($data);
        // dd($status);
        if($status){
            request()->session()->flash('success','Successfully added user');
        }
        else{
            request()->session()->flash('error','Error occurred while adding user');
        }
        return redirect()->route('users.index');

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
        $user=User::findOrFail($id);
        return view('backend.users.edit')->with('user',$user);
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
        $user=User::findOrFail($id);
        $request->validate([
            'name'      =>  'string|required|max:30',
            'email'     =>  'string|required',
            'role'      =>  'required|in:admin,user',
            'status'    =>  'required|in:active,inactive',
        ]);

        $path = null;
        if($request->hasfile('photo')){
            $image  = $request->file('photo');
            $path   = 'Images/user/' . uniqid() . '.' . $image->extension();
            $image->move(public_path('Images/user'), $path);
        }else{
            $path   = $user->photo;
        }
        $data=$request->all();
        $data['photo']      =   $path;
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated');
        }
        else{
            request()->session()->flash('error','Error occured while updating');
        }
        return redirect()->route('users.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete=User::findorFail($id);
        $status=$delete->delete();
        if($status){
            request()->session()->flash('success','User Successfully deleted');
        }
        else{
            request()->session()->flash('error','There is an error while deleting users');
        }
        return redirect()->route('users.index');
    }
}
