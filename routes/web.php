<?php

 use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Artisan;
    use App\Http\Controllers\{AdminController,OrderController,ProductReviewController,BannerController,HomeController,SpecificationController,ProductController,BrandController,
        CategoryController,UsersController,FaqController,ContactUsController,OtherBannerController,ProductVariantController,CollectionController};
    use App\Http\Controllers\Frontend\{FrontendHomeController,AuthController,AccountController,WishListController};
    use App\Http\Middleware\LanguageSwitcher;
    use App\Http\Controllers\Admin\{DiscountCodeController,AttributeController,PageController};







Route::get('/income', [OrderController::class, 'incomeChart'])->name('product.order.income');
Route::controller(AdminController::class)->group(function () {
    Route::get('admin/login','login')->name('admin-login');
    Route::get('password-reset','reset')->name('password.request');
    Route::post('admin/logins', 'adminLogin')->name('admin.login');
    Route::get('admin/forget-password', 'forgetPassword')->name('admin.forget');
    Route::post('admin/confirm-otp', 'confirmOtp')->name('confirm.otp');
    Route::post('admin/reset-password', 'resetPassword')->name('admin.passwordReset');
});





Route::resource('/review', ProductReviewController::class);
Route::group(['prefix' => '/admin', 'middleware' => ['auth','admin']], function () {





    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::controller(AdminController::class)->group(function () {
        // Settings

        
        Route::get('settings','settings')->name('settings');
        Route::post('setting/update','settingsUpdate')->name('settings.update');



        // Password Change
        Route::get('change-password','changePassword')->name('change.password.form');
        Route::post('logout','logout')->name('logout');
        Route::post('change-password','changPasswordStore')->name('change.password');
         // Profile
        Route::get('/profile','profile')->name('admin-profile');
        Route::post('/profile/{id}','profileUpdate')->name('profile-update');
    });         


    // Banner
    Route::resource('banner', BannerController::class);
    Route::resource('banners', OtherBannerController::class);


    // Brand
    Route::resource('brand', BrandController::class);
    Route::get('/brands/display', [BrandController::class,'displayData'])->name('brand.display');


    // Category
    Route::resource('/category', CategoryController::class);
     



  
    //collection
    Route::resource('/collection', CollectionController::class);
    Route::get('/coll/display', [CollectionController::class,'displayData'])->name('collection.display');


    // Ajax for sub category
    Route::post('/category/{id}/child', [CategoryController::class,'getChildByParent']);
    Route::get('/cat/display', [CategoryController::class,'displayData'])->name('category.display');
    // Product
    Route::resource('/product', ProductController::class);
  Route::controller(ProductController::class)->group(function () {
    Route::get('/prod/display','displayData')->name('product.display');
    Route::get('/products/brand','brands')->name('product.brand');
    Route::get('/sales/update','salesUpdate')->name('update.Sales');
    Route::get('/delete/image','deleteImage')->name('delete.image');

    Route::get('/products/export','export')->name('products.export');
    Route::post('/products/import','import')->name('products.import');
});

     

    //
    Route::resource('/specification', SpecificationController::class);
    Route::controller(SpecificationController::class)->group(function () {
        Route::post('/specification/{id}/data','getSpecification');
        Route::get('/spec/display','displayData')->name('specification.display');
    });




    // Order
    Route::resource('/order', OrderController::class);
    Route::get('/orders/display',[OrderController::class,'displayData'])->name('order.display');



    // user route
    Route::resource('users', UsersController::class);
    Route::get('/user/display', [UsersController::class,'displayData'])->name('user.display');
    Route::resource('/faq', FaqController::class);
    Route::get('/faqs/display', [FaqController::class,'displayData'])->name('faq.display');
    Route::get('reviews/display',[ProductReviewController::class,'displayData'])->name('review.display');
    Route::controller(ContactUsController::class)->group(function () {
        Route::get('/contact-us','index')->name('contact.index');
        Route::get('/contact/display','displayData')->name('contact.display');
    });


    // product variant 
    Route::controller(ProductVariantController::class)->group(function () {
        Route::get('/product-variant/{id}', 'index')->name('product-variant');
        Route::get('/variant/display','displayData')->name('variant.display');
        Route::get('/variant/create/{id}','create')->name('variant.create');
        Route::post('/variant/store','store')->name('variant.store');
        Route::get('/variant/edit/{product_id}/{variant_id}','edit')->name('variant.edit');
        Route::post('/variant/update','update')->name('variant.update');
        Route::delete('/variant/delete/{id}','delete')->name('variant.delete');
    });


      // caupon code here
      Route::get('discount', [DiscountCodeController::class, 'index'])->name('discount.index');
      Route::get('discount/create', [DiscountCodeController::class, 'create'])->name('discount.create');
      Route::post('discount/store', [DiscountCodeController::class, 'store'])->name('discount.store');
      Route::get('discount/edit/{id}', [DiscountCodeController::class, 'edit'])->name('discount.edit');
      Route::post('discount/update/{id}', [DiscountCodeController::class, 'update'])->name('discount.update');
      Route::get('discount/delete/{id}', [DiscountCodeController::class, 'destroy'])->name('discount.delete');
      Route::get('discount/status/{id}', [DiscountCodeController::class, 'toggleStatus'])->name('discount.status');
  
 


      // Add Attribute 
      Route::get('attributes', [AttributeController::class, 'index'])->name('admin.attributes.index');
      Route::get('attributes/create', [AttributeController::class, 'create'])->name('admin.attributes.create');
      Route::post('attributes', [AttributeController::class, 'store'])->name('admin.attributes.store');
      Route::get('attributes/{id}/edit', [AttributeController::class, 'edit'])->name('admin.attributes.edit');
      Route::put('attributes/{id}', [AttributeController::class, 'update'])->name('admin.attributes.update');
      Route::delete('attributes/{id}', [AttributeController::class, 'destroy'])->name('admin.attributes.destroy');
      




      Route::get('pages', [PageController::class, 'index'])->name('admin.pages');
      Route::get('pages/create', [PageController::class, 'create'])->name('admin.pages.create');
      Route::post('pages/store', [PageController::class, 'store'])->name('pages.store');
      Route::get('pages/edit/{page}', [PageController::class, 'edit'])->name('pages.edit');
      Route::put('pages/update/{page}', [PageController::class, 'update'])->name('pages.update');


    // frontend dynamic page route (bottom of web.php)
    // Route::get('/{slug}', function ($slug) {
    // $page = \App\Models\Page::where('slug', $slug)->firstOrFail();
    //  return view('frontend.page', compact('page'));
    //  });





});
// web panel panels












//User Panels
Route::controller(AuthController::class)->prefix('user')->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/auth', 'auth')->name('user-auth');
    Route::get('/register', 'Register')->name('user-register');
    Route::post('/sign-up', 'SignUp')->name('user-signup');
    Route::get('/verification', 'verification')->name('verification');
    Route::post('/otp-verification', 'otpVerification')->name('otp-verification');
    Route::get('/verify-email', 'verifyEmail')->name('verify-email');
    Route::get('/change-password', 'changePassword')->name('change-password');
    Route::post('/update-password', 'updatePassword')->name('update-password');
    Route::get('/resend-otp', 'reSendOtp')->name('resend-otp');
});



// Frontend code 
Route::group(['prefix' => '/user', 'middleware' => ['auth','user']], function () {
    Route::controller(AccountController::class)->group(function () {
        Route::get('/account', 'profile')->name('user-profile');
        Route::get('/order', 'orders')->name('order');
        Route::get('/return-order', 'returnOrder')->name('return-order');
        Route::get('/reset-password', 'resetPassword')->name('reset-password');
        Route::get('/enquiry', 'enquiry')->name('enquiry');
        Route::get('/tracking', 'tracking')->name('tracking');
        Route::get('account/wishlist', 'wishlist')->name('account-wishlist');
        Route::get('/cart', 'cart')->name('cart');
        Route::get('/add-to-cart', 'addToCart')->name('add-to-cart');
        Route::get('/update-quantity', 'updateQuantity')->name('update-quantity');
        Route::get('/remove-cart', 'removeProductCart')->name('remove-cart');
        Route::get('logout','logout')->name('user-logout');
    });
    Route::controller(WishListController::class)->group(function () {
        Route::get('/wishlist', 'wishlist')->name('wishlist');
        Route::get('/remove-wishlist', 'removeWishlist')->name('remove-wishlist');
        Route::get('/add-remove-wishlist', 'addRemoveWishList')->name('add-remove-wishlist');
    });


});







Route::group(['prefix' => '{language}', 'middleware' => 'language'], function () {
    Route::get('/', [FrontendHomeController::class, 'index'])->name('home');
    Route::get('/shop', [FrontendHomeController::class, 'shop'])->name('shop');
    Route::get('/contact-us', [FrontendHomeController::class, 'contact'])->name('contact');
    Route::get('terms/{slug}', [FrontendHomeController::class, 'product'])->name('product');
    Route::post('/change-variant', [FrontendHomeController::class, 'changeVariant'])->name('change-variant');
    Route::get('product-listing', [FrontendHomeController::class, 'productList'])->name('product.listing');
    Route::post('/contact-inquiry', [FrontendHomeController::class, 'inquiry'])->name('inquiry');
});