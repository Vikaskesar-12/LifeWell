<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\SignUpRequest;
use App\Models\User;
use App\Mail\{UserSignUpMail,ForgetPasswordMail};
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\{Auth,Hash,Cookie};

class AuthController extends Controller
{
    public function index(){
        try{
            session::forget('email');
            session::forget('opt');
            return view('frontend.auth.login');
        }catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
    public function Register(){
        try{
            session::forget('email');
            session::forget('opt');
            return view('frontend.auth.register');
        }catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->with('error','something went wrong');
        }
    }

    public function auth(Request $request){
        $request->validate([
            'email'    => 'email|required',
            'password' => 'required',
        ]);
        try{
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password , 'role' => 'user'])) {
                if ($request->has('remember')) {
                    Cookie::queue('email', $request->email, 1440);
                    Cookie::queue('password', $request->password, 1440);
                } else {
                    Cookie::queue('email', "", 1440);
                    Cookie::queue('password', "", 1440);
                }
                return redirect('/');
            }
            return redirect()->back()->with('error', 'invalid credantials');
        }catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
    public function SignUp(SignUpRequest $request){
        try{
            $otp         = str_pad(mt_rand(100000, 999999), 6, '0', STR_PAD_LEFT);
            $currentTime = now();
            Session::put('otp', $otp);
            Session::put($request->all());
            Session::put('time',$currentTime);
            if($request->type == 'register'){
                \Mail::to($request->email)->send(new UserSignUpMail($otp,$request->name));
            }else{
                $user = User::where('email',$request->email)->first();
                \Mail::to($request->email)->send(new ForgetPasswordMail($otp,$user->name));
            }
            return redirect('/user/verification')->with('success','otp send on your email please check and verify');
        }catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->with('error','something went wrong');
        }
    }
    public function verification(){
        try{
            $otp = Session::has('otp');
            if($otp)
                return view('frontend.auth.verification');
            else
                return redirect('/user/login');
        }catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    public function otpVerification(Request $request){
        try{
            $otp         = implode($request->otp);
            $matchOtp    = Session::get('otp');
            $time        = Session::get('time');
            $type        = Session::get('type');
            $currentTime = now();
            $diff        = $time->diffInMinutes($currentTime);
            if(!$otp || $otp !== $matchOtp || $diff > 10){
                return redirect()->back()->with('error','Invalide otp or maybe expire');
            }else if($type == 'register'){
                $user = User::create([
                    'name'              => Session::get('name'),
                    'email'             => Session::get('email'),
                    'mobile'            => Session::get('mobile'),
                    'password'          => Hash::make(Session::get('password')),
                    'email_verified_at' => now(),
                ]);
                Session::flush();
                return redirect('user/login')->with('success','you have successfully registered.please login!');
            }else{
                return redirect('user/change-password')->with('success','you have successfully registered.please login!');
            }
        }catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    public function verifyEmail(){
        return view('frontend.auth.check-email');
    }

    public function changePassword(){
        try{
            $email = Session::has('email');
            if($email)
                return view('frontend.auth.change-password');
            else
                return redirect('/user/login');
        }catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    public function updatePassword(Request $request){
        $request->validate([
            'password' => 'required',
        ]);
        try{
            $email = Session::get('email');
            $user = User::where('email',$email)->update([
                'password' => Hash::make($request->password),
            ]);
            if($user){
                Session::flush();
                return redirect('/user/login')->with('success','password change successfully.plaese login!');
            }    
            else
                return redirect()->back()->with('success','somthing went wrong!');
        }catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    public function reSendOtp(Request $request){
        try{
            $otp         = str_pad(mt_rand(100000, 999999), 6, '0', STR_PAD_LEFT);
            $currentTime = now();
            Session::put('otp', $otp);
            Session::put('time',$currentTime);
            $email = Session::get('email');
            $name  = Session::get('name');
            $type  = Session::get('type');
            if($type == 'register'){
                \Mail::to($email)->send(new UserSignUpMail($otp,$name));
            }else{
                $user = User::where('email',$email)->first();
                \Mail::to($email)->send(new ForgetPasswordMail($otp,$user->name));
            }
            return redirect()->back()->with('success','otp send on your email please check and verify');
        }catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->with('error','something went wrong');
        }
    }
    
}
