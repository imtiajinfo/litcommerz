<?php

// namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\ProductController;
use App\Http\Controllers\web\ShopController;
use App\Http\Controllers\web\CartController;
use App\Http\Controllers\web\CheckoutController;
use App\Http\Controllers\web\AboutController;
use App\Http\Controllers\web\FaqController;
use App\Http\Controllers\web\WishlistController;
use App\Http\Controllers\web\OrderController;
use App\Http\Controllers\web\ContactController;
use App\Http\Controllers\web\TermConditionController;
use App\Http\Controllers\web\BlogController as WebBlog;
use App\Http\Controllers\web\ProfileSettingController as UserProfileSettingController;
use App\Http\Controllers\web\CouponOfferController;
use App\Http\Controllers\web\ReviewController;
use App\Http\Controllers\web\OthersController;

// admin 
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\admin\MasterController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\ProductController as AdminProduct;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\RolePermissionController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\ProfileSettingController;
use App\Http\Controllers\admin\UserAccessController;
use App\Http\Controllers\admin\TestController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\OrderController as AdminOrder;
use App\Http\Controllers\admin\SpecialProductController;
use App\Http\Controllers\admin\HotItemProductController;
use App\Http\Controllers\admin\NewArrivalProductController;
use App\Http\Controllers\admin\AdminBrandController;
use App\Http\Controllers\admin\StockController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\OfferController;
use App\Http\Controllers\admin\OfferProductController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\CouponCategoryController;
use App\Http\Controllers\admin\UnitController;
use App\Http\Controllers\admin\ContactController as AdminContactController;
use App\Http\Controllers\admin\AboutController as AdminAbout;
use App\Http\Controllers\admin\FaqController as AdminFaq;
use App\Http\Controllers\admin\OthersController as AdminOthers;
use App\Http\Controllers\admin\MailSettingController;
use App\Http\Controllers\admin\RegionController;
use App\Http\Controllers\admin\DeliveryChargeController;

// frontend 

Route::get('/config-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return "<h1>Cache Cleared!</h1>";
});
Route::get('/db-seed', function () {
    // Artisan::call('db:seed');
    Artisan::call('migrate');

    return "<h1>Success!</h1>";
});

Route::fallback(function () {
    return redirect('/');
});

    
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class, 'pro_details'])->name('product.details');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop.index');
Route::get('/shop-ajax', [ShopController::class, 'shop_ajax'])->name('shop.ajax');
Route::get('/category/{category_slug}', [ShopController::class, 'category_product'])->name('shop.category.product');
Route::get('/sub-category/{subcategory_slug}', [ShopController::class, 'subcategory_product'])->name('shop.subcategory.product');

Route::get('/carts', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart-add', [CartController::class, 'cart_add'])->name('cart.add');
Route::get('/ajax-cart-view', [CartController::class, 'ajax_cart_view'])->name('cart.ajax_view');
Route::get('/cart-destroy', [CartController::class, 'cart_destroy'])->name('cart.destroy');
Route::get('/cart-destroy/{index}', [CartController::class, 'single_cart_destroy'])->name('cart.single.destroy');
Route::get('/cart-remove-ajax', [CartController::class, 'cart_remove_ajax'])->name('cart.ajax.destroy');
Route::get('/buy-now-cart/{id}', [CartController::class, 'buy_now_cart'])->name('buy_now.cart');
Route::get('/details-buy-now-cart/{id}', [CartController::class, 'details_buy_now_cart'])->name('details_buy_now.cart');
Route::get('/cart-plus', [CartController::class, 'cart_plus'])->name('cart.plus');
Route::get('/cart-minus', [CartController::class, 'cart_minus'])->name('cart.minus');
Route::get('/cart-change-qty', [CartController::class, 'cart_qty_change'])->name('cart.qty.change');
Route::post('/coupon-apply', [CartController::class, 'coupon_apply'])->name('coupon.apply');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');
Route::get('/about', [AboutController::class, 'index'])->name('about.index');
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/terms-and-conditions', [TermConditionController::class, 'index'])->name('terms_conditions.index');
Route::get('/blogs', [WebBlog::class, 'index']);
Route::get('/blog/{slug}', [WebBlog::class, 'single_blog']);

Route::get('/shipping-details', [OthersController::class, 'shipping_details'])->name('shipping-details');
Route::get('/physical-store', [OthersController::class, 'physical_store']);
Route::get('/banner-gallery', [OthersController::class, 'banner_gallery']);
Route::get('/how-to-order', [OthersController::class, 'how_to_order']);
Route::get('/privacy-policy', [OthersController::class, 'privacy_policy']);

Route::get('/complain-form', [OthersController::class, 'complain_form']);
Route::post('/complain-form', [OthersController::class, 'complain_form_store'])->name('complain_form_store');

// forget password 
Route::get('/forget-password', [AuthController::class, 'lost_password']);
Route::post('/forget-password-verify-code', [AuthController::class, 'lost_password_verify_code'])->name('lost_password_verify_code');
Route::get('/forget-password/{token}', [AuthController::class, 'lost_password_token']);
Route::post('/forget-password', [AuthController::class, 'lost_password_token_post'])->name('lost_password_token_post');

// coupon offers 
Route::get('/coupon-offers', [CouponOfferController::class, 'index']);
Route::get('/spcial-offers/{slug}', [CouponOfferController::class, 'special_offer']);
Route::get('/hot-items', [CouponOfferController::class, 'hot_items']);
Route::get('/new-arrivals', [CouponOfferController::class, 'new_arrivals'])->name('new.arrivals');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/invoice/{order_id}', [OrderController::class, 'invoice'])->name('order.user.invoice');
Route::get('/order-success/{order_id}', [OrderController::class, 'order_success']);

Route::group(['middleware' => 'user_auth'], function () {

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::get('/wishlist/store', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::get('/wishlist/store1', [WishlistController::class, 'store1']);
    Route::get('/wishlist-destory/{id}', [WishlistController::class, 'destory'])->name('wishlist.destory');
    
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::resource('my-profile', UserProfileSettingController::class);

    Route::post('reviewSubmit', [ReviewController::class, 'store'])->name('reviewSubmit');

});

// admin 
Route::get('/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/admin-loginAction', [AuthController::class, 'loginAction'])->name('admin.login.action');
Route::post('/loginAction', [AuthController::class, 'webloginAction'])->name('login.action');
Route::post('/checkoutloginAction', [AuthController::class, 'webcheckoutloginAction'])->name('login.checkout.action');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'register'])->name('register.index');
Route::post('/register-action', [AuthController::class, 'registerAction'])->name('register.action');
Route::post('/register-checkout-action', [AuthController::class, 'registerCheckoutAction'])->name('register.checkout.action');
Route::post('/register-admin-action', [AuthController::class, 'adminRegisterAction'])->name('admin.register.action');
Route::get('/verify-your-mail', [AuthController::class, 'verify_your_email'])->name('email.your_verify');
Route::get('/verify-email/{verification_code}', [AuthController::class, 'verify_email'])->name('email.verify');

Route::get('/category-wise-sub-category/{id}', [CommonController::class, 'category_wise_sub_category']);

Route::group(['middleware' => 'admin_auth', 'prefix' => 'admin-panel', 'as' => 'admin.'], function () {
    
    Route::get('/', [MasterController::class, 'master'])->name('master');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('category', CategoryController::class);
    Route::get('category-sorting', [CategoryController::class, 'category_sorting'])->name('category.sorting');
    Route::resource('subcategory', SubCategoryController::class);
    Route::resource('product', AdminProduct::class);
    Route::get('product/{id}/reviews', [AdminProduct::class, 'reviews']);
    Route::patch('reviews/status/{id}', [AdminProduct::class, 'updateStatus'])->name('reviews.status.update');
    Route::resource('roles', RoleController::class);
    Route::resource('rolePermissions', RolePermissionController::class);
    Route::resource('generalSettings', SettingController::class);
    Route::resource('profileSettings', ProfileSettingController::class);

    //Delivery charge
    Route::resource('regions', RegionController::class);
    Route::resource('delivery-charges', DeliveryChargeController::class);

    Route::get('user-list', [UserAccessController::class, 'index'])->name('user.list');
    Route::get('user/create', [UserAccessController::class, 'create'])->name('user.create');
    Route::post('user/store', [UserAccessController::class, 'store'])->name('user.store');
    Route::get('user/edit-role', [UserAccessController::class, 'edit'])->name('user.edit_role');
    Route::get('user/change-password', [UserAccessController::class, 'password']);
    Route::post('user/change-password', [UserAccessController::class, 'change_password'])->name('user.change_password');
    Route::post('user/update-role', [UserAccessController::class, 'update'])->name('user.role_update');
    Route::get('details-info', [UserAccessController::class, 'details'])->name('user.details');
    Route::get('all-orders', [UserAccessController::class, 'orders'])->name('user.orders');
    Route::delete('user/delete/{id}', [UserAccessController::class, 'destroy'])->name('user.delete');
    
    Route::get('test', [TestController::class, 'index'])->name('test');
    Route::resource('orders', AdminOrder::class);
    Route::get('orders-edit/{id}', [AdminOrder::class, 'order_edit'])->name('order_edit');
    Route::post('orders-update/{id}', [AdminOrder::class, 'order_update'])->name('order_update');
    Route::resource('banner', BannerController::class);
    Route::resource('sepecialProduct', SpecialProductController::class);
    Route::resource('hotItems', HotItemProductController::class);
    Route::resource('newArrivals', NewArrivalProductController::class);
    Route::resource('brands', AdminBrandController::class);
    Route::resource('stocks', StockController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('offers', OfferController::class);
    Route::get('offer-sorting', [OfferController::class, 'offer_sorting'])->name('offers.sorting');
    Route::resource('offer_products', OfferProductController::class);
    Route::resource('coupon_categorys', CouponCategoryController::class);
    Route::resource('coupons', CouponController::class);
    
    Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::post('contact/mark-read', [AdminContactController::class, 'markAsRead'])->name('contact.mark-read');
    Route::resource('units', UnitController::class);
    Route::resource('about', AdminAbout::class);
    Route::resource('faq', AdminFaq::class);

    Route::get('complains', [AdminOthers::class, 'complains'])->name('complains.index');
    Route::post('/complain/mark-read', [AdminOthers::class, 'markComplainRead'])->name('complain.mark-read');
    // shipping details 
    Route::get('shippingDetails', [AdminOthers::class, 'shippingDetails'])->name('shippingDetails.index');
    Route::post('shippingDetails', [AdminOthers::class, 'shippingDetails_store'])->name('shippingDetails.store');
    // physical store 
    Route::get('physicalStore', [AdminOthers::class, 'physicalStore'])->name('physicalStore.index');
    Route::post('physicalStore', [AdminOthers::class, 'physicalStore_store'])->name('physicalStore.store');
    // banner gallery 
    Route::get('bannerGallary', [AdminOthers::class, 'bannerGallary'])->name('bannerGallary.index');
    Route::post('bannerGallary', [AdminOthers::class, 'bannerGallary_store'])->name('bannerGallary.store');
    // how to order
    Route::get('howToOrder', [AdminOthers::class, 'howToOrder'])->name('howToOrder.index');
    Route::post('howToOrder', [AdminOthers::class, 'howToOrder_store'])->name('howToOrder.store');
    // terms and conditions
    Route::get('termsConditions', [AdminOthers::class, 'termsConditions'])->name('termsConditions.index');
    Route::post('termsConditions', [AdminOthers::class, 'termsConditions_store'])->name('termsConditions.store');
    // terms and conditions
    Route::get('privacyPolicy', [AdminOthers::class, 'privacyPolicy'])->name('privacyPolicy.index');
    Route::post('privacyPolicy', [AdminOthers::class, 'privacyPolicy_store'])->name('privacyPolicy.store');
    // email setting
    Route::get('mailSetting', [MailSettingController::class, 'index'])->name('mailSetting.index');
    Route::post('mailSetting', [MailSettingController::class, 'store'])->name('mailSetting.store');

});

Route::get('admin/invoice/{order_id}', [AdminOrder::class, 'invoice'])->name('order.invoice');
Route::get('admin/invoice-pdf/{order_id}', [AdminOrder::class, 'invoice_pdf'])->name('order.invoice.pdf');
Route::get('admin/purchase-invoice/{id}', [AdminOrder::class, 'purchase_invoice'])->name('order.purchase.invoice');
Route::get('load-product', [AdminOrder::class, 'load_product']);

Route::get('/export', [AdminProduct::class, 'export']);

