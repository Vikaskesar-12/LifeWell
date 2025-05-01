<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Category,Product,ProductReview,Specification,Banner,OtherBanner,ProductVariant,
    Settings,Contact};

class FrontendHomeController extends Controller
{
    public function index(Request $request){
        $categories     = Category::where('status','active')->get();
        $reviews        = ProductReview::where('status','active')->with('user_info','product')->get();
        $productsQuery  = ProductVariant::where('status','active')->with('productImage')->orderBy('id', 'DESC');
        $banners        = Banner::whereStatus('active')->get();
        $deals          = (clone $productsQuery)->whereHas('product',function($query){
                                $query->where('deal_of_the_day', 1);
                            })->get();
                            
        $bestSeller     = (clone $productsQuery)->whereHas('product',function($query){
                                $query->where('best_seller', 1);
                            })->get();
                           
        $featured       =  (clone $productsQuery)->whereHas('product',function($query){
                                $query->where('is_featured', 1);
                            })->get(); 

        $topRated       = (clone $productsQuery)->whereHas('product',function($query){
                                $query->where('top_rated', 1);
                            })->get();

        $onSale         = (clone $productsQuery)->whereHas('product',function($query){
                                $query->where('on_sale', 1);
                            })->get();
        $product        = $productsQuery->limit(10)->get();
        return view('frontend.index',compact('categories','deals','product','featured','topRated','onSale','reviews','bestSeller','banners'));
    }

    public function Shop(){
        $categories     = Category::where('status','active')->where('is_parent',1)->get();
        $reviews        = ProductReview::where('status','active')->with('user_info','product')->get();
        $product        = ProductVariant::where('status','active')->with('productImage')->orderBy('id', 'DESC')->limit(10)->get();
        return view('frontend.shop.shop',compact('categories','reviews','product'));
    }

    public function product(Request $request,$slug){
        $product       = ProductVariant::with('product','productSpecification','productImages')->
                            where('slug',$slug)->first();
        if($product){
           return $this->productDetail($product);
        }
            
        $cat          = Category::where('slug',$slug)->first();
        if(!$cat){
            return redirect('/');
        }
        $filterCategory     = isset($request->category) & is_array($request->category) ?
                                $request->category : [];
        $filerids           = Category::whereIn('slug',$filterCategory)->pluck('id')->toArray();
        $limit              = $request->take ? $request->take : 20; 
        $cat_id             = $cat->id;
        $category           = Category::whereHas('sub_products')->where('parent_id',$cat_id)->get();
        $banner             = OtherBanner::where('category_id',$cat_id)->first();
        $specification      = Specification::with('ProductSpec')->whereIn('category_id',$filerids)->get();
        $query              = ProductVariant::where('status', 'active')
                                ->filter($request)
                                ->with('productImage')
                                ->whereHas('product',function($query) use($cat_id) {
                                    $query->where('cat_id', $cat_id);
                                });

        $products = $query->orderBy('id', 'DESC')->paginate($limit);
        $productCount = $query->count();
        return view('frontend.product.list',compact('productCount','products','cat','category','limit','specification','banner'));
    }

    private function productDetail($product){
        $productVariant = Product::with('variant')->find($product->product_id);
        $specification = array_column($productVariant->variant->toarray(),'product_specification');
            foreach ($specification as $group) {
                foreach ($group as $item) {
                    $groupedData[$item['name']][] = $item['type'];
                }
            }
            foreach ($groupedData as $key => $values) {
                $groupedData[$key] = array_unique($values);
            }
        $selected =  collect($product->productSpecification)->pluck('type', 'name')->toArray();
        return view('frontend.product.product_details',compact('product','productVariant','groupedData','selected'));
    }

    // public function productList(Request $request){
    //     $cat          = Category::where('slug',$request->slug)->first();
    //     $cat_id       = $cat->id;
    //     $category     = Category::where('parent_id',$cat_id)->get();
    //     $query        = Product::where('status', 'active')
    //                     ->filter($request)
    //                     ->with('productImage')
    //                     ->where('cat_id', $cat_id);

    //     $product = $query->orderBy('id', 'DESC')->take($request->take)->get();
    //     $productCount = $query->count();
    //     return response()->json([
    //                                 'status'    => true, 
    //                                 'data'      => $product, 
    //                                 'category'  => $category,
    //                                 'cat'       => $cat, 
    //                                 'count'     => $productCount
    //                             ]);
    // }

    public function contact(){
        $data = Settings::first();
        return view('frontend.contact-us',compact('data'));
    }

    public function inquiry(Request $request){
        $request->validate([
            'first_name'    =>  'required',
            'last_name'     =>  'required',
            'email'         =>  'required',
            'message'       =>  'required'
        ]);
        $data = Contact::create($request->all());
        return redirect()->back()->with('success','Inquiry request send to the select.mu');
    }

    public function ChangeVariant(Request $request){
        // dd($request->all());
       $variant = ProductVariant::find($request->id);
       
       $variants = ProductVariant::where('product_id',$variant->product_id)->whereHas('productSpecification',function($query) use($request){
        $query->where('name',$request->name)->where('type',$request->type);
       })->first();
       return redirect()->route('product',$variants->slug);
    }
}
