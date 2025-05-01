<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{WishList,Cart};

class WishListController extends Controller
{
    public function addRemoveWishList(Request $request){
        try{
            $wish = WishList::where('user_id',auth()->user()->id)->where('product_variant_id',$request->id)->first();
            $cart = Cart::where('user_id',auth()->user()->id)->where('product_variant_id',$request->id)->first();
            if($wish){
                $wish->delete();
                $count = WishList::where('user_id',auth()->user()->id)->count();
                return response()->json(['status' => 'remove','count' => $count]);
            }else{
                WishList::create([
                    'user_id' => auth()->user()->id,
                    'product_variant_id' => $request->id,
                    'cart_id'   => $cart ? $cart->id : null,
                ]);
                $count = WishList::where('user_id',auth()->user()->id)->count();
                return response()->json(['status' => 'add','count' => $count]);
            }
        }catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    public function wishlist(){
        $wishlistCount = WishList::where('user_id',auth()->user()->id)->get();
        return view('frontend.wishlist.wishlist');
    }

    public function removeWishlist(Request $request){
        $wishlist = WishList::find($request->id);
        if($wishlist){
            $wishlist->delete();
        }
        return redirect()->back()->with('success','product has been remove from wishlist');
    }
}
