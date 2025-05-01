<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\User;
use App\Models\Product;


use App\Rules\MatchOldPassword;
use App\Mail\ResetPasswordmail;
use Hash;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AdminController extends Controller
{

    public function login(Request $request){
        if(auth()->user() && auth()->user()->role == 'admin'){
            return redirect('/admin');
        }
        return view('backend.login');
    }

    public function adminLogin(Request $request){
        $request->validate([
            'email'    => 'email|required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password , 'role' => 'admin'])) {
            if ($request->has('remember')) {
                Cookie::queue('email', $request->email, 1440);
                Cookie::queue('password', $request->password, 1440);
            } else {
                Cookie::queue('email', "", 1440);
                Cookie::queue('password', "", 1440);
            }
            return redirect('/admin');
        }
        return redirect()->back()->with('error', 'invalid credantials');
    }

    public function reset(Request $request){
       
        return view('auth.passwords.email');
    }

    public function forgetPassword(Request $request){
       
        $request->validate([
            'email'    => 'email|required',
        ]);
        try {
            $data = User::where('email',$request->email)->where('role','admin')->first();
            $otp  = rand(1000,9999);
            if($data){
                $currentTime = now(); 
                $time = session('time');
                if (!$time || $time->diffInMinutes($currentTime) > 2) {
                    session()->put(['otp' => $otp, 'time' => $currentTime]);
                    \Mail::to($request->email)->send(new ResetPasswordmail($otp));
                }
                return view('auth.passwords.otp',compact('data'));
            }
            return redirect()->back()->with('error', 'plaese enter the correct email');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function confirmOtp(Request $request){
        
        $request->validate([
            'email'    => 'email|required',
            'otp'      => 'array|min:4|required',
        ]);
        try {

            $data = User::where('email',$request->email)->where('role','admin')->first();
            $otp  = implode($request->otp);
            $sessionOtp = session('otp');
            if ($data && $sessionOtp && $otp == $sessionOtp) {
                session()->forget('otp');
                session()->forget('time');
                return view('auth.passwords.confirm',compact('data'));
            } else {
                return redirect()->back()->with('error', 'Invalid OTP.');
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function resetPassword(Request $request){
        $request->validate([
            'email'    => 'email|required',
            'password' => 'required',
        ]);
        try {

            $data = User::where('email',$request->email)->where('role','admin')->first();
            if ($data) {
                $data->update([
                    'password' => Hash::make($request->password)
                ]);
                return redirect('/admin')->with('success','password reset successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong');
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function index()
    {
        // Fetch user data for the last 7 days (Day name and count)
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
            ->where('created_at', '>', Carbon::today()->subDays(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
    
        // Prepare the data for the chart
        $array[] = ['Day', 'Number of Users'];
        foreach ($data as $key => $value) {
            $array[] = [$value->day_name, $value->count];
        }
    
        // Fetch all products from the database
        $products = Product::all();  // Fetching all products from the database
    
        // Return the view and pass both the 'users' and 'products' data
        return view('backend.index', [
            'users' => json_encode($array),
            'products' => $products
        ]);
    }
    


    

    public function profile(){
        $profile=Auth()->user();
        return view('backend.users.profile',compact('profile'));
    }

    public function profileUpdate(Request $request,$id){
        $user=User::findOrFail($id);
        $path = null;
        if($request->hasfile('photo')){
            $image  = $request->file('photo');
            $path   = 'Images/user/' . uniqid() . '.' . $image->extension();
            $image->move(public_path('Images/user'), $path);
        }else{
            $path   = $user->photo;
        }
        $data           =   $request->all();
        $data['photo']  =   $path;
        $status         =   $user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated your profile');
        }
        else{
            request()->session()->flash('error','Please try again!');
        }
        return redirect()->back();
    }

    public function settings(){
        $data=Settings::first();
        return view('backend.setting')->with('data',$data);
    }

    public function settingsUpdate(Request $request){
        $request->validate([
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email'
        ]);
        $id = ['id' => $request->id ? $request->id : null];
        $pathlogo = null;
        if($request->hasfile('logo')){
            $image  = $request->file('logo');
            $pathlogo   = 'Images/' . uniqid() . '.' . $image->extension();
            $image->move(public_path('Images'), $pathlogo);
        }else{
            $settings   = Settings::find($request->id);
            $pathlogo   = $settings ? $settings->logo : '';
        }
        // dd($request->all());
        $status = Settings::updateOrCreate($id,[
                'about_us'        =>  $request->aboutUs,
                'privacy_policy'  =>  $request->privacy_policy,
                'return_policy'   =>  $request->return_policy,
                'logo'            =>  $pathlogo,
                'address'         =>  $request->address,
                'phone'           =>  $request->phone,
                'email'           =>  $request->email    
        ]);
        if($status){
            request()->session()->flash('success','Setting successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again');
        }
        return redirect()->route('admin');
    }

    public function changePassword(){
        return view('backend.layouts.changePassword');
    }

    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password'      => ['required', new MatchOldPassword],
            'new_password'          => ['required'],
            'new_confirm_password'  => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->route('admin')->with('success','Password successfully changed');
    }

    // Pie chart
    public function userPieChart(Request $request){
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
     $array[] = ['Name', 'Number'];
     foreach($data as $key => $value)
     {
       $array[++$key] = [$value->day_name, $value->count];
     }
    //  return $data;
     return view('backend.index')->with('course', json_encode($array));
    }

    public function logout(){
        Auth()->logout();
        return redirect('admin/login');
    }
}
