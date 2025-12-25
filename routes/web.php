<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginRegController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\VenderController;
use App\Http\Controllers\SuppliersController;
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'homepage'])->name('homepage');

Route::get('/login-register', [LoginRegController::class, 'login_register'])->name('login_register');

// Page load (GET)
Route::get('/search-vendor', [HomeController::class, 'search_vendor'])->name('search_vendor');

// GET Route: To display the search form
Route::get('/search-customer', [HomeController::class, 'search_customer'])->name('search_customer');

Route::get('/cutomer-profile', [HomeController::class, 'cutomerprofile'])->name('cutomerprofile');
Route::post('/profile/cutomerupdate', [HomeController::class, 'cutomerupdate'])->name('profile.cutomerupdate');
// POST Route: To handle form submissions and filters
Route::post('/search-customer', [HomeController::class, 'search_customer_post'])->name('search_customer_post');

// Form submit (POST)
Route::post('/search-vendor', [HomeController::class, 'search_vendor_post'])->name('search_vendor_post');

Route::get('/get-regions/{state_id}', [HomeController::class, 'getRegions']);
Route::get('/get-cities/{region_id}', [HomeController::class, 'getCities']);


Route::post('/register', [LoginRegController::class, 'register'])->name('register');
Route::post('/login', [LoginRegController::class, 'login'])->name('login');
Route::get('/dashboard', [LoginRegController::class, 'dashboard'])->name('dashboard'); // after login
Route::get('/vendor-dashboard', [LoginRegController::class, 'vendordashboard'])->name('vendordashboard'); // after login
Route::get('/Supplier-dashboard', [LoginRegController::class, 'supplierdashboard'])->name('supplierdashboard'); // after login

Route::get('/logout', [LoginRegController::class, 'logout'])->name('logout');


Route::get('/post', [HomeController::class, 'post'])->name('post');

// Route::get('/get-subtypes/{id}', [HomeController::class, 'getSubtypes']);
Route::get('/get-project-types/{workType}', [HomeController::class, 'getProjectTypes']);

Route::get('/my-posts', [HomeController::class, 'index'])->name('myposts');
Route::post('/save-post', [HomeController::class, 'store'])->name('save.post');

Route::get('/Lead-Marketplace', [HomeController::class, 'leadmarketplace'])->name('leadmarketplace');

Route::post('/save-site-visit', [HomeController::class, 'saveSiteVisit'])->name('save.site.visit');
Route::get('/site-visit/pdf/{id}', [HomeController::class, 'downloadPDF'])->name('site.visit.pdf');
// Vendor Notifications – View All
Route::get('/vendor/notifications', [HomeController::class, 'vendorNotifications'])
    ->name('vendor.notifications');

Route::get('/user/notifications', [HomeController::class, 'userNotifications'])
    ->name('user.notifications');


    // Mark Single Notification as Read
Route::get('/vendor/notification/read/{id}', [HomeController::class, 'readVendorNotification'])
    ->name('vendor.read.notification');


Route::get('/vendor/register', [HomeController::class, 'vendorRegister'])->name('vendor.register');
Route::get('/supplier/register', [HomeController::class, 'supplierRegister'])->name('supplier.register');

Route::get('/project-details-ajax', [HomeController::class, 'getProjectDetails'])
    ->name('project.details.ajax');

Route::post('/save-leadform', [HomeController::class, 'storeleadform'])->name('save.leadform');


Route::get('/pay', [RazorpayController::class, 'showPaymentForm'])->name('razorpay.form');

Route::get('/vendor_reg_form', [HomeController::class, 'vendor_reg_form'])->name('vendor_reg_form');


Route::post('/razorpay/payment', [RazorpayController::class, 'handlePayment'])->name('razorpay.payment');

// Route::get('/profile', [VenderController::class, 'venderprofile'])->name('venderprofile');
Route::get('/vendor/profile', [VenderController::class, 'venderprofile'])
    ->name('vendor.profile');

Route::get('/supplier/profile', [SuppliersController::class, 'suppliersprofile'])
    ->name('suppliers.profile');
   
    
Route::post('/supplierstore', [SuppliersController::class, 'supplierstore'])->name('supplier.store');
Route::get('/addproducts', [SuppliersController::class, 'addproducts'])->name('addproducts');

Route::post('/supplier/products/save', [SuppliersController::class, 'saveProducts'])
     ->name('supplier.products.save');

// Route::post('/vendor/profile/update-field', [VenderController::class, 'updateVendorField'])
//     ->name('vendor.profile.update.field');
Route::post('/vendor/profile/update', [VenderController::class, 'updateProfile'])
    ->name('vendor.profile.update');

Route::get('/get-subtypes/{id}', [VenderController::class, 'getSubtypes']);
Route::get('/get-suppliers', [SuppliersController::class, 'supplierserch'])->name('supplierserch');

Route::get('/productenquiry', [SuppliersController::class, 'productenquiry'])->name('productenquiry');


Route::post('/supplier-enquiry', [SuppliersController::class, 'supplierenquirystore'])
    ->name('supplier.enquiry.store');


Route::post('/vendor-interest-check', [HomeController::class, 'vendorinterestcheck'])
    ->name('vendor.interest.check');

Route::post('/project-interest-check', 
    [HomeController::class, 'projectInterestCheck']
)->name('project.interest.check');

Route::get('/my-posts/{id}', [HomeController::class, 'postsshow'])->name('posts.view');

Route::put('/posts/{id}', [HomeController::class, 'updateposts'])->name('posts.update');

Route::get('/delete-post/{id}', [HomeController::class, 'destroy'])->name('posts.delete');

Route::get('/make-hash', function () {
    // $password = "Trimurti@1234";
    //  $password = "Civilworker123@";
    $password = "123456789";
    $hash = Hash::make($password);

    return $hash; 
});