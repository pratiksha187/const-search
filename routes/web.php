<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginRegController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\VenderController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\MaterialCategoryController;
use App\Http\Controllers\MaterialProductController;
use App\Http\Controllers\MaterialProductSubtypeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProfileTypeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ThicknessSizeController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StandardController;
use App\Http\Controllers\whightController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AdminController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'homepage'])->name('homepage');
Route::get('admindashboard', [LoginRegController::class, 'admindashboard'])->name('admindashboard');
Route::get('addmaster', [MasterController::class, 'addmaster'])->name('addmaster');
Route::get('/about-us', [HomeController::class, 'aboutus'])->name('aboutus');

Route::get('/login-register', [LoginRegController::class, 'login_register'])->name('login_register');
Route::post('/change-password', [LoginRegController::class, 'changePassword'])->name('change-password');

// Page load (GET)
Route::get('/search-vendor', [HomeController::class, 'search_vendor'])->name('search_vendor');

// GET Route: To display the search form
Route::get('/search-customer', [HomeController::class, 'search_customer'])->name('search_customer');

Route::get('/cutomer-profile', [HomeController::class, 'cutomerprofile'])->name('cutomerprofile');
Route::post('/profile/cutomerupdate', [HomeController::class, 'cutomerupdate'])->name('profile.cutomerupdate');


// Route::get('/get-regions/{state_id}', [HomeController::class, 'getRegions']);
// Route::get('/get-cities/{region_id}', [HomeController::class, 'getCities']);


Route::post('/register', [LoginRegController::class, 'register'])->name('register');
Route::post('/login', [LoginRegController::class, 'login'])->name('login');
Route::get('/dashboard', [LoginRegController::class, 'dashboard'])->name('dashboard'); // after login
Route::get('/vendor-dashboard', [LoginRegController::class, 'vendordashboard'])->name('vendordashboard'); // after login
Route::get('/Supplier-dashboard', [LoginRegController::class, 'supplierdashboard'])->name('supplierdashboard'); // after login

Route::get('/logout', [LoginRegController::class, 'logout'])->name('logout');


Route::get('/post', [HomeController::class, 'post'])->name('post');

// Route::post('/posts/{id}', [AdminController::class, 'verifyPost'])->name('posts.verify');
Route::post('/posts/{id}', [AdminController::class, 'verifyPost'])
    ->name('posts.verify');


Route::get('/postverification', [AdminController::class, 'postverification'])->name('postverification');


// Route::get('/get-subtypes/{id}', [HomeController::class, 'getSubtypes']);
Route::get('/get-project-types/{workType}', [HomeController::class, 'getProjectTypes']);

Route::get('/my-posts', [HomeController::class, 'index'])->name('myposts');
Route::post('/save-post', [HomeController::class, 'store'])->name('save.post');

Route::get('/Lead-Marketplace', [HomeController::class, 'leadmarketplace'])->name('leadmarketplace');


Route::get('postsubscription', [HomeController::class, 'postsubscription'])->name('postsubscription');


Route::get('/vendor/register', [HomeController::class, 'vendorRegister'])->name('vendor.register');
Route::get('/supplier/register', [HomeController::class, 'supplierRegister'])->name('supplier.register');



Route::post('/save-leadform', [HomeController::class, 'storeleadform'])->name('save.leadform');


Route::get('/pay', [RazorpayController::class, 'showPaymentForm'])->name('razorpay.form');
Route::post('/razorpay/handle', [RazorpayController::class, 'handlePayment'])
    ->name('razorpay.handle');

Route::post('vendor.razorpay.verify', [RazorpayController::class, 'handlePayment'])
    ->name('razorpay.handle');
    
Route::post('/after-project-payment', [HomeController::class, 'afterProjectPayment'])
    ->name('after.project.payment');

Route::post('/razorpay/create-order', [RazorpayController::class, 'createOrder'])
    ->name('razorpay.createOrder');

Route::post('/razorpay/verify', [RazorpayController::class, 'verifyPayment'])
    ->name('razorpay.verify');

Route::get('/vendor_reg_form', [HomeController::class, 'vendor_reg_form'])->name('vendor_reg_form');

Route::get('/quotes&order', [SuppliersController::class, 'quotesandorder'])->name('quotes.orders');

Route::post('/razorpay/payment', [RazorpayController::class, 'handlePayment'])->name('razorpay.payment');

Route::get('/vendor/profile', [VenderController::class, 'venderprofile'])
    ->name('vendor.profile');

Route::get('/supplier/profile', [SuppliersController::class, 'suppliersprofile'])
    ->name('suppliers.profile');
   
    
Route::post('/supplierstore', [SuppliersController::class, 'supplierstore'])->name('supplier.store');
Route::get('/addproducts', [SuppliersController::class, 'addproducts'])->name('addproducts');
Route::get('/mystore', [SuppliersController::class, 'mystore'])->name('mystore');



Route::get('/myproducts', [SuppliersController::class, 'myproducts'])->name('myproducts');
Route::get('/products/edit/{id}', [SuppliersController::class, 'editProduct'])
    ->name('products.edit');

Route::post('/products/update/{id}', [SuppliersController::class, 'updateProduct'])
    ->name('products.update');

Route::get('/products/delete/{id}', [SuppliersController::class, 'deleteProduct'])
    ->name('products.delete');


Route::get('/get-product-subtypes/{productId}', [SuppliersController::class, 'getProductSubtypes']);
Route::get('/get-brands/{productId}', [SuppliersController::class, 'getBrands']);


Route::post(
    '/supplier-products/store',
    [SuppliersController::class, 'storeSupplierProductData']
)->name('supplier-products.store');


Route::get('/get-profile-types/{subCategoryId}', 
    [SuppliersController::class, 'getProfileTypes']
);


Route::get('/get-product-meta/{id}', [SuppliersController::class, 'getProductMeta']);

Route::post('/supplier/products/save', [SuppliersController::class, 'saveProducts'])
     ->name('supplier.products.save');

Route::get('/locations/regions/{stateId}', [MasterController::class, 'getRegions']);
Route::get('/locations/cities/{regionId}', [MasterController::class, 'getCities']);

Route::post('/vendor/profile/update', [VenderController::class, 'updateProfile'])
    ->name('vendor.profile.update');

Route::get('/get-subtypes/{id}', [VenderController::class, 'getSubtypes']);
Route::get('/search-suppliers', [SuppliersController::class, 'supplierserch'])->name('supplierserch');
Route::get('vendor-lead-history', [VenderController::class, 'vendorleadhistory'])->name('vendorleadhistory');

Route::post('/supplier-search/ajax', [SuppliersController::class, 'supplierSearchAjax'])
    ->name('supplier.search.ajax');

Route::get('/supplier-filter', [SuppliersController::class, 'supplierFilter'])
    ->name('supplier.search.filter');

Route::get('/productenquiry', [SuppliersController::class, 'productenquiry'])->name('productenquiry');
Route::get('/check_lead_balance', [VenderController::class, 'checkLeadBalance'])->name('vendor.check_lead_balance');
Route::get('/vendor/check-already-interest', [VenderController::class, 'checkAlreadyInterest'])
    ->name('vendor.check_already_interest');


Route::post('/productenquirystore', [HomeController::class, 'productenquirystore'])->name('productenquirystore');
// web.php
Route::get(
    '/supplier-enquiry/{id}',
    [SuppliersController::class, 'supplierenquiryshow']
)->name('supplier.enquiry.show');

Route::get('/supplier-enquiries', [SuppliersController::class, 'allsupplierenquiry'])
    ->name('supplier.enquiry.index');

Route::post('/supplier-enquiry', [SuppliersController::class, 'supplierenquirystore'])
    ->name('supplier.enquiry.store');

Route::get('/supplier/profile/{id}', [SuppliersController::class, 'supplierprofileid'])
    ->name('supplier.profile');

    
Route::get('/vendor/profile/id/{id}', [VenderController::class, 'vendorprofileid'])
    ->name('vendor.profile.id');
 
    
Route::get('/customer/profile/id/{id}', [HomeController::class, 'customerprofileid'])
    ->name('customer.profile.id');    

Route::post('/vendor-interest-check', [HomeController::class, 'vendorinterestcheck'])
    ->name('vendor.interest.check');
Route::post('/claim-free-lead', [VenderController::class, 'claimFreeLead'])
    ->name('claim_free_lead');
Route::post('/customer-interest-check', [HomeController::class, 'customerinterestcheck'])
    ->name('customer.interest.check');

Route::get('/vendorsubscription', [VenderController::class, 'vendorsubscription'])->name('vendorsubscription');

Route::get('/test', [ImportController::class, 'test'])->name('test');

Route::get('/admin/free-leads', [AdminController::class, 'freeLeadList'])
    ->name('admin.freeleads');

Route::post('/admin/free-leads/{id}/action',
    [AdminController::class, 'freeLeadAction']
)->name('admin.freeleads.action');

Route::post('/project-interest-check', 
    [HomeController::class, 'projectInterestCheck']
)->name('project.interest.check');

Route::get('/my-posts/{id}', [HomeController::class, 'postsshow'])->name('posts.view');

Route::put('/posts/{id}', [HomeController::class, 'updateposts'])->name('posts.update');

Route::get('/delete-post/{id}', [HomeController::class, 'destroy'])->name('posts.delete');

Route::post('/import-posts', [ImportController::class, 'import']);

Route::resource('material-categories', MaterialCategoryController::class);
Route::post('material-categories/status/{id}', 
    [MaterialCategoryController::class, 'updateStatus']
)->name('material-categories.status');

Route::resource('material-products', MaterialProductController::class);
Route::resource(
    'material-product-subtypes',
    MaterialProductSubtypeController::class
);

Route::resource('brands', BrandController::class);
Route::resource('profiletypes', ProfileTypeController::class);
Route::get('/unit-master', [UnitController::class,'index'])->name('unit.index');
Route::post('/unit-store', [UnitController::class,'store'])->name('unit.store');
Route::post('/unit-update/{id}', [UnitController::class,'update'])->name('unit.update');
Route::get('/unit-delete/{id}', [UnitController::class,'destroy'])->name('unit.delete');
Route::get('/thickness-size-master', [ThicknessSizeController::class,'index'])
        ->name('thickness.size.index');

Route::post('/thickness-size-store', [ThicknessSizeController::class,'store'])
        ->name('thickness.size.store');

Route::post('/thickness-size-update/{id}', [ThicknessSizeController::class,'update'])
        ->name('thickness.size.update');

Route::get('/thickness-size-delete/{id}', [ThicknessSizeController::class,'destroy'])
        ->name('thickness.size.delete');


Route::get('/grade-master', [GradeController::class,'index'])
        ->name('grade.index');

Route::post('/grade-store', [GradeController::class,'store'])
        ->name('grade.store');

Route::post('/grade-update/{id}', [GradeController::class,'update'])
        ->name('grade.update');

Route::get('/grade-delete/{id}', [GradeController::class,'destroy'])
        ->name('grade.delete');


Route::get('/whight-master', [whightController::class,'index'])
    ->name('whight.index');

Route::post('/whight-store', [whightController::class,'store'])
    ->name('whight.store');

Route::post('/whight-update/{id}', [whightController::class,'update'])
    ->name('whight.update');

Route::get('/whight-delete/{id}', [whightController::class,'destroy'])
    ->name('whight.delete');

Route::get('/standard-master', [StandardController::class,'index'])
    ->name('standard.index');

Route::post('/standard-store', [StandardController::class,'store'])
    ->name('standard.store');

Route::post('/standard-update/{id}', [StandardController::class,'update'])
    ->name('standard.update');

Route::get('/standard-delete/{id}', [StandardController::class,'destroy'])
    ->name('standard.delete');

Route::post('/erp-interest/save', [HomeController::class, 'saveErpInterest'])
    ->name('erp.interest.save');

// projects-list
Route::get('/projects-list', [HomeController::class,'projectslist'])
    ->name('projectslist');

Route::get('/projects/{id}', [HomeController::class, 'projectsshow'])->name('projects.show');

Route::get('/admin/vendors', [HomeController::class, 'vendorslist'])
    ->name('admin.vendors.index');

Route::get('/admin/suppliers', [HomeController::class, 'supplierslist'])
    ->name('admin.suppliers.index');

Route::get('/admin/suppliers/{id}', [HomeController::class, 'suppliersshow'])
    ->name('admin.suppliers.show');

Route::delete('/admin/suppliers/{id}', [HomeController::class, 'suppliersdestroy'])
    ->name('admin.suppliers.destroy');

Route::get('/admin/vendors/{id}', [HomeController::class, 'vendorsshow'])
    ->name('admin.vendors.show');

Route::get('/admin/vendors/approved/{id}', [AdminController::class, 'vendorsapproved'])
    ->name('admin.vendorsapproved');

    Route::get('/admin/supplier/approved/{id}', [AdminController::class, 'supplierapproved'])
    ->name('admin.supplierapproved');


    Route::post('/admin/vendors/{id}/status',
        [AdminController::class, 'updateStatus']
    )->name('admin.vendors.status');

    Route::post('/admin/supplier/{id}/status',
        [AdminController::class, 'updatesupplierStatus']
    )->name('admin.supplier.status');


 // STATE
    Route::get('/states', [StateController::class, 'index'])->name('states.index');
    Route::post('/states', [StateController::class, 'store'])->name('states.store');

    // REGION
    Route::get('/regions', [RegionController::class, 'index'])->name('regions.index');
    Route::post('/regions', [RegionController::class, 'store'])->name('regions.store');
    Route::get('/regions/by-state/{state}', 
            [RegionController::class, 'byState']
        )->name('regions.byState');

    // CITY
    Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
    Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
    Route::get('/cities/by-region/{region}', [CityController::class, 'byRegion']);

    // Route::get('/customer/notifications', [LoginRegController::class, 'getCustomerNotifications'])->name('customer.notifications');
    Route::get('/customer/notifications', [LoginRegController::class, 'customerNotificationsPage'])->name('customer.notifications');

    Route::get('/vendor/notifications', [LoginRegController::class, 'vendorNotificationsPage'])->name('vendor.notifications');
    
    Route::post('/vendor/rate', [VenderController::class, 'storerate'])
    ->name('vendor.rate');

    Route::post(
        '/customer/notification/action',
        [LoginRegController::class, 'handleNotificationAction']
    )->name('customer.notification.action');
   
    Route::get('vendor_verification', [AdminController::class, 'vendor_verification'])->name('vendor_verification');
    Route::get('supplier_verification', [AdminController::class, 'supplier_verification'])->name('supplier_verification');

    Route::post('/send-suppliersenquiry', [HomeController::class, 'suppliersenquirystore'])
     ->name('enquiry.store');

    // Route::post('freeleadupload', [AdminController::class, 'freeleadupload'])->name('vendor.freelead.upload');
    Route::post('/vendor/free-lead/upload', 
        [AdminController::class, 'uploadFreeLead']
    )->name('vendor.freelead.upload');

    Route::post('/supplier/send-quote', [SuppliersController::class, 'sendQuote'])
     ->name('supplier.sendQuote');

    Route::get('/auth/{action?}/{role?}', function () {
        return view('web.login_register');
    })->where(['action' => 'login|register', 'role' => 'customer|vendor|supplier']);

  

    Route::post('/forgot-password/send-otp', [LoginRegController::class, 'sendOtp']);
    Route::post('/forgot-password/verify-otp', [LoginRegController::class, 'verifyOtp']);
    Route::post('/forgot-password/reset', [LoginRegController::class, 'resetPassword']);

    Route::get('/make-hash', function () {
    // $password = "Trimurti@1234";
    //  $password = "Civilworker123@";
    $password = "123456789";
    $hash = Hash::make($password);

    return $hash; 
});