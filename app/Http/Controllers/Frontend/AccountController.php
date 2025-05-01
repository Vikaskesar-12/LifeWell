<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Cart,WishList,Product,ProductVariant};


class AccountController extends Controller
{
    public function profile(){
        return view('frontend.account.profile');
    }
    public function orders(){
        return view('frontend.account.order');
    }
    public function returnOrder(){
        return view('frontend.account.return-order');
    }
    public function resetPassword(){
        return view('frontend.account.reset-password');
    }
    public function enquiry(){
        return view('frontend.account.enquiry');
    }
    public function wishlist(){
        return view('frontend.account.wishlist');
    }
    public function tracking(){
        return view('frontend.account.tracking');
    }
    public function logout(){
        Auth()->logout();
        return redirect()->route('home');
    }

    public function cart(){
        $wishlistCount = WishList::where('user_id',auth()->user()->id)->get();
        return view('frontend.cart.cart');
    }

    public function addToCart(Request $request){
        try{
            $wish = WishList::where('user_id',auth()->user()->id)->where('product_variant_id',$request->id)->first();
            $cart = Cart::where('user_id',auth()->user()->id)->where('product_variant_id',$request->id)->first();
            if($cart){
                $cart->update(['quantity' => $cart->quantity + 1]);
            }else{
                $carts = Cart::create([
                    'user_id' => auth()->user()->id,
                    'product_variant_id' => $request->id,
                ]);
                if($wish){
                    $wish->update([
                        'cart_id' => $carts->id,
                    ]);
                }   
            }
            $count = Cart::where('user_id',auth()->user()->id)->count();
            return response()->json(['status' => true,'count' => $count]);
        }catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    } 

    public function updateQuantity(Request $request){
        try{
            $cart    = Cart::find($request->id);
            $Product = ProductVariant::find($cart->product_variant_id);
            if($Product->stock == $cart->quantity && $request->status == 'increase'){
                return response()->json(['status' => false,'stock' => $Product->stock]);
            }
            if($cart->quantity == 1 && $request->status == 'decrease'){
                return response()->json(['status' => true,'cart' => $cart]);
            }
            if($cart){
                $cart->update(['quantity' => $request->status == 'increase' ? 
                                                $cart->quantity + 1 :
                                                $cart->quantity - 1]);
                $cart = Cart::with('product')->find($request->id);
                return response()->json(['status' => true,'cart' => $cart]);
            }
            
        }catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    } 

    public function removeProductCart(Request $request){
        $cart = Cart::find($request->id);
        $productId = $cart ? $cart->product_variant_id : null;
        $wish = WishList::where('user_id',auth()->user()->id)->where('product_variant_id',$productId)->first();
        if($wish){
            $wish->update([
                'cart_id' => null,
            ]);
        }
        if($cart){
            $cart->delete();
        }
        return redirect()->back()->with('success','product has been remove from cart');
    }
}
