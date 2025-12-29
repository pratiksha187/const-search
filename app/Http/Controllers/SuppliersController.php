<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\SupplierEnquiry;
use App\Models\Suppliers;
class SuppliersController extends Controller
{
  
    public function suppliersprofile()
    {
        $supplier_id = Session::get('supplier_id');
        //  dd( $supplier_id );
        $primary_type   = DB::table('materials')->get();
        $experience  = DB::table('years_in_business')->get();
        $delivery_type = DB::table('delivery_type')->get();
        $credit_days =DB::table('credit_days')->get();
        $maximum_distances =DB::table('maximum_distances')->get();
        // Example: get supplier by logged-in user
        $supplier = DB::table('supplier_reg')
                    ->where('id', $supplier_id)
                    ->first();

        return view('web.suppliersprofile', compact(
            'primary_type',
            'experience',
            'supplier',
            'credit_days',
            'delivery_type',
            'maximum_distances'
        
        ));
    }


    // public function supplierstore(Request $request)
    // {
    //     dd($request);
    //     $supplier_id = Session::get('supplier_id');
    //     // dd($supplier_id);
    //     $validated = $request->validate([
    //         'user_id'           => ['required', 'integer'], 
    //         // Basic info
    //         'shop_name'         => ['required', 'string', 'max:255'],
    //         'contact_person'    => ['required', 'string', 'max:255'],
    //         'phone'             => ['required', 'string', 'max:20'],
    //         'whatsapp'          => ['nullable', 'string', 'max:20'],
    //         'email'             => ['required', 'email', 'max:255'],
    //         'shop_address'      => ['required', 'string'],

    //         // City/Area
    //         'city'              => ['nullable'],
    //         'area'              => ['nullable'],

    //         // Business
    //         'primary_type'      => ['nullable'],
    //         'years_in_business' => ['nullable'],

    //         // PAN & GST
    //         'gst_number'        => ['nullable'],
    //         'pan_number'        => ['nullable'],
    //         'msme_status'       => ['nullable'],

    //         // Products & Categories
    //         'open_time'        => ['nullable'],
    //         'close_time.*'     => ['nullable'],
    //         'credit_days'      => ['nullable'],

          
    //         'minimum_order_cost' => ['nullable'],
    //         'delivery_days' => ['nullable'],
    //         'delivery_type' => ['nullable'],
    //         'distance_km' => ['nullable'],
    //         'maximum_distance' => ['nullable'],
            

    //         // Brands
    //         'brands_supplied'   => ['nullable', 'string'],

    //         // Pricing
    //         'price'             => ['nullable', 'numeric', 'min:0'],
    //         'discount_price'    => ['nullable', 'numeric', 'min:0'],
    //         'gst_percent'       => ['nullable', 'numeric', 'min:0', 'max:100'],

    //         // Service areas
    //         'service_areas'     => ['nullable', 'array'],
    //         'service_areas.*'   => ['string', 'max:100'],

    //         // Files
    //         'gst_certificate'   => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
    //         'pan_card'          => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
    //         'shop_license'      => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
    //         'sample_invoice'    => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
    //         'costing_sheet'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],

    //         // Images
    //         'images'            => ['nullable', 'array'],
    //         'images.*'          => ['file', 'image', 'max:5120'],

    //         // Bank
    //         'account_holder'    => ['required', 'string', 'max:255'],
    //         'bank_name'         => ['required', 'string', 'max:255'],
    //         'account_number'    => ['required', 'string', 'max:64'],
    //         'ifsc_code'         => ['required', 'string', 'max:20'],

    //         // Agreement
    //         'confirm_details'   => ['accepted'],
    //         'agree_terms'       => ['accepted'],
    //     ], [
    //         'gst_number.regex'  => 'Enter a valid GST number (e.g., 22AAAAA0000A1Z5).',
    //         'pan_number.regex'  => 'Enter a valid PAN number (e.g., ABCDE1234F).',
    //     ]);

    //     // Handle file uploads
    //     $docs = [];
    //     foreach (['gst_certificate', 'pan_card', 'shop_license', 'sample_invoice', 'costing_sheet'] as $docField) {
    //         if ($request->hasFile($docField)) {
    //             $docs[$docField] = $request->file($docField)->store("products/docs", 'public');
    //         }
    //     }

    //     // Handle multiple images
    //     $imagePaths = [];
    //     if ($request->hasFile('images')) {
    //         foreach ($request->file('images') as $img) {
    //             $imagePaths[] = $img->store("products/images", 'public');
    //         }
    //     }
    //     // $user_id=  $validated['user_id'];
    //     // $supplier_id = Session::get('supplier_id');
      
    //     // dd($supplier_id);
    //    $product = Suppliers::create([
    //             'user_id'             => $user_id,

    //             // Basic
    //             'shop_name'           => $validated['shop_name'],
    //             'contact_person'      => $validated['contact_person'],
    //             'phone'               => $validated['phone'],
    //             'whatsapp'            => $validated['whatsapp'] ?? null,
    //             'email'               => $validated['email'],
    //             'shop_address'        => $validated['shop_address'],
    //             'city_id'             => $validated['city'],
    //             'area_id'             => $validated['area'],

    //             // Business
    //             'primary_type'        => $validated['primary_type'] ?? null,
    //             'years_in_business'   => $validated['years_in_business'] ?? null,
    //             'gst_number'          => $validated['gst_number'],
    //             'pan_number'          => $validated['pan_number'],
    //             'msme_status'         => $validated['msme_status'] ?? null,

    //             // Delivery & Credit
    //             'open_time'           => $validated['open_time'] ?? null,
    //             'close_time'          => $validated['close_time'] ?? null,
    //             'credit_days'         => $validated['credit_days'] ?? null,
    //             'delivery_type'       => $validated['delivery_type'],
    //             'delivery_days'       => $validated['delivery_days'] ?? null,
    //             'minimum_order_cost'  => $validated['minimum_order_cost'] ?? null,
    //             'maximum_distance'    => $validated['maximum_distance'] ?? null,

    //             // Files
    //             'gst_certificate_path'=> $docs['gst_certificate'] ?? null,
    //             'pan_card_path'       => $docs['pan_card'] ?? null,
    //             'shop_license_path'   => $docs['shop_license'] ?? null,
    //             'sample_invoice_path' => $docs['sample_invoice'] ?? null,
    //             'costing_sheet'       => $docs['costing_sheet'] ?? null,

    //             // Images
    //             'images'              => $imagePaths ? json_encode($imagePaths) : null,

    //             // Bank
    //             'account_holder'      => $validated['account_holder'],
    //             'bank_name'           => $validated['bank_name'],
    //             'account_number'      => $validated['account_number'],
    //             'ifsc_code'           => $validated['ifsc_code'],
    //         ]);

    //     $product->save();

    //     // Return JSON response for AJAX, or redirect normally
    //     if ($request->ajax() || $request->wantsJson()) {
    //         return response()->json([
    //             'message'  => 'Product created successfully.',
    //             'id'       => $product->id,
    //             'redirect' => route('products.create'),
    //         ]);
    //     }

    //     return redirect()->route('products.create')->with('success', 'Product created successfully.');
    // }
// public function supplierstore(Request $request)
// {
    
//     /* ===============================
//        SESSION
//     =============================== */
//     $supplier_id = Session::get('supplier_id');
//     // dd($supplier_id);
//     if (!$supplier_id) {
//         return back()->with('error', 'Unauthorized');
//     }

//     /* ===============================
//        VALIDATION
//     =============================== */
//     $validated = $request->validate([
//         'shop_name'         => 'required',
//         'contact_person'    => 'required|string|max:255',
//         'phone'             => 'required|string|max:20',
//         'whatsapp'          => 'nullable|string|max:20',
//         'email'             => 'required|email|max:255',
//         'shop_address'      => 'required|string',

//         'city'              => 'nullable',
//         'area'              => 'nullable',

//         'primary_type'      => 'nullable',
//         'years_in_business' => 'nullable',

//         'gst_number'        => 'nullable',
//         'pan_number'        => 'nullable',
//         'msme_status'       => 'nullable',

//         'open_time'         => 'nullable',
//         'close_time'        => 'nullable',
//         'credit_days'       => 'nullable',
//         'delivery_type'     => 'nullable',
//         'delivery_days'     => 'nullable',
//         'minimum_order_cost'=> 'nullable',
//         'maximum_distance'  => 'nullable',

//         'gst_certificate'   => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
//         'pan_card'          => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
//         'shop_license'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
//         'sample_invoice'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
//         'costing_sheet'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

//         'images'            => 'nullable|array',
//         'images.*'          => 'image|max:5120',

//         'account_holder'    => 'required|string|max:255',
//         'bank_name'         => 'required|string|max:255',
//         'account_number'    => 'required|string|max:64',
//         'ifsc_code'         => 'required|string|max:20',

//         'confirm_details'   => 'accepted',
//         'agree_terms'       => 'accepted',
//     ]);

//     // dd($validated);
//     /* ===============================
//        FILE UPLOADS
//     =============================== */
//     $docs = [];
//     foreach (['gst_certificate','pan_card','shop_license','sample_invoice','costing_sheet'] as $field) {
//         if ($request->hasFile($field)) {
//             $docs[$field] = $request->file($field)->store('supplier/docs', 'public');
//         }
//     }

//     $imagePaths = [];
//     if ($request->hasFile('images')) {
//         foreach ($request->file('images') as $img) {
//             $imagePaths[] = $img->store('supplier/images', 'public');
//         }
//     }

//     /* ===============================
//        INSERT (NO SAVE() NEEDED)
//     =============================== */
//     $supplier = Suppliers::create([
//         // 'user_id'            => $supplier_id,

//         'shop_name'          => $validated['shop_name'],
//         'contact_person'     => $validated['contact_person'],
//         'phone'              => $validated['phone'],
//         'whatsapp'           => $validated['whatsapp'] ?? null,
//         'email'              => $validated['email'],
//         'shop_address'       => $validated['shop_address'],
//         'city_id'            => $validated['city'],
//         'area_id'            => $validated['area'],

//         'primary_type'       => $validated['primary_type'],
//         'years_in_business'  => $validated['years_in_business'],
//         'gst_number'         => $validated['gst_number'],
//         'pan_number'         => $validated['pan_number'],
//         'msme_status'        => $validated['msme_status'],

//         'open_time'          => $validated['open_time'],
//         'close_time'         => $validated['close_time'],
//         'credit_days'        => $validated['credit_days'],
//         'delivery_type'      => $validated['delivery_type'],
//         'delivery_days'      => $validated['delivery_days'],
//         'minimum_order_cost' => $validated['minimum_order_cost'],
//         'maximum_distance'   => $validated['maximum_distance'],

//         'gst_certificate_path'=> $docs['gst_certificate'] ?? null,
//         'pan_card_path'      => $docs['pan_card'] ?? null,
//         'shop_license_path'  => $docs['shop_license'] ?? null,
//         'sample_invoice_path'=> $docs['sample_invoice'] ?? null,
//         'costing_sheet'      => $docs['costing_sheet'] ?? null,

//         'images'             => $imagePaths,
//         'account_holder'     => $validated['account_holder'],
//         'bank_name'          => $validated['bank_name'],
//         'account_number'     => $validated['account_number'],
//         'ifsc_code'          => $validated['ifsc_code'],

//         'status'             => 'pending',
//     ]);

//     return redirect()->back()->with('success', 'Supplier registered successfully');
// }
public function supplierstore(Request $request)
{
    /* ===============================
       SESSION CHECK
    =============================== */
    $supplier_id = Session::get('supplier_id');
    // dd($supplier_id);

    if (!$supplier_id) {
        return back()->with('error', 'Unauthorized');
    }

    /* ===============================
       VALIDATION
    =============================== */
    $validated = $request->validate([
        'shop_name'         => 'nullable',
        'contact_person'    => 'nullable',
        'mobile'             => 'nullable',
        'whatsapp'          => 'nullable',
        'email'             => 'nullable',
        'shop_address'      => 'nullable',

        // 'city'              => 'nullable',
        // 'area'              => 'nullable',

        // 'primary_type'      => 'nullable',
        'years_in_business' => 'nullable',

        'gst_number'        => 'nullable',
        'pan_number'        => 'nullable',
        'msme_status'       => 'nullable',

        'open_time'         => 'nullable',
        'close_time'        => 'nullable',
        'credit_days'       => 'nullable',
        'delivery_type'     => 'nullable',
        'delivery_days'     => 'nullable',
        'minimum_order_cost'=> 'nullable',
        'maximum_distance'  => 'nullable',

        'gst_certificate'   => 'nullable',
        'pan_card'          => 'nullable',
        'shop_license'      => 'nullable',
        'sample_invoice'    => 'nullable',
        'costing_sheet'     => 'nullable',

        'images'            => 'nullable',
        'images.*'          => 'image',

        'account_holder'    => 'nullable',
        'bank_name'         => 'nullable',
        'account_number'    => 'nullable',
        'ifsc_code'         => 'nullable',

        'confirm_details'   => 'nullable',
        'agree_terms'       => 'nullable',
    ]);

    /* ===============================
       FIND SUPPLIER
    =============================== */
    $supplier = Suppliers::where('id', $supplier_id)->first();
// dd( $supplier);

    /* ===============================
       FILE UPLOADS (KEEP OLD IF NOT RE-UPLOADED)
    =============================== */
    foreach (['gst_certificate','pan_card','shop_license','sample_invoice','costing_sheet'] as $field) {
        if ($request->hasFile($field)) {
            $supplier->{$field.'_path'} =
                $request->file($field)->store('supplier/docs', 'public');
        }
    }

    if ($request->hasFile('images')) {
        $imgs = [];
        foreach ($request->file('images') as $img) {
            $imgs[] = $img->store('supplier/images', 'public');
        }
        $supplier->images = $imgs;
    }

    /* ===============================
       UPDATE DATA
    =============================== */
    $supplier->fill([
        'shop_name'          => $validated['shop_name'],
        'contact_person'     => $validated['contact_person'],
        'mobile'              => $validated['mobile'],
        'whatsapp'           => $validated['whatsapp'] ?? null,
        'email'              => $validated['email'],
        'shop_address'       => $validated['shop_address'],
        // 'city_id'            => $validated['city'],
        // 'area_id'            => $validated['area'],

        // 'primary_type'       => $validated['primary_type'],
        'years_in_business'  => $validated['years_in_business'],
        'gst_number'         => $validated['gst_number'],
        'pan_number'         => $validated['pan_number'],
        'msme_status'        => $validated['msme_status'],

        'open_time'          => $validated['open_time'],
        'close_time'         => $validated['close_time'],
        'credit_days'        => $validated['credit_days'],
        'delivery_type'      => $validated['delivery_type'],
        'delivery_days'      => $validated['delivery_days'],
        'minimum_order_cost' => $validated['minimum_order_cost'],
        'maximum_distance'   => $validated['maximum_distance'],

        'account_holder'     => $validated['account_holder'],
        'bank_name'          => $validated['bank_name'],
        'account_number'     => $validated['account_number'],
        'ifsc_code'          => $validated['ifsc_code'],

        'status'             => 'pending',
    ]);

    $supplier->save();

    return redirect()->back()->with('success', 'Supplier details updated successfully');
}


    public function addproducts(){
         $supplier_id = Session::get('supplier_id');
         $supplier = DB::table('supplier_products')
        ->where('supplier_id', $supplier_id)
        ->first();
        return view('web.addproduct', compact('supplier'));
    }

    public function saveProducts(Request $request)
    {
        // $supplierId = auth()->id(); 
        $supplier_id = Session::get('supplier_id');
       
      /* ===============================
       1. VALIDATION
    =============================== */
    $request->validate([
        'categories'         => 'nullable|array',
        'category_products'  => 'nullable|array',
    ]);

    /* ===============================
       2. SELECTED CATEGORIES
    =============================== */
    $categories = $request->input('categories', []);

    /* ===============================
       3. BUILD PRODUCT JSON
    =============================== */
    $productDetails = [];

    foreach ($request->input('category_products', []) as $category => $items) {

        // Skip unselected category
        if (!in_array($category, $categories)) {
            continue;
        }

        $names  = $items['name']  ?? [];
        $units  = $items['unit']  ?? [];
        $prices = $items['price'] ?? [];

        foreach ($names as $i => $name) {

            // Skip empty product rows
            if (trim($name) === '') continue;

            $productDetails[$category][] = [
                'name'  => $name,
                'unit'  => $units[$i]  ?? '',
                'price' => $prices[$i] ?? '',
            ];
        }
    }

    /* ===============================
       4. INSERT OR UPDATE
       (ONE RECORD PER SUPPLIER)
    =============================== */
    DB::table('supplier_products')->updateOrInsert(
        ['supplier_id' => $supplier_id],
        [
            'categories'      => json_encode($categories),
            'product_details' => json_encode($productDetails),
            'status'          => 1,
            'updated_at'      => now(),
            'created_at'      => now(),
        ]
    );

    return back()->with('success', 'Products & categories saved successfully');
    }

    // public function supplierserch(){

    //     $credit_days =DB::table('credit_days')->get();
    //     $delivery_type =DB::table('delivery_type')->get();
    //     $maximum_distances =DB::table('maximum_distances')->get();
    //     $supplier_data = DB::table('supplier_reg')->get();
    //     // dd($supplier_data);
    //     return view('web.supplierserch',compact('credit_days','delivery_type','maximum_distances','supplier_data'));
    // }

    

    public function supplierserch()
    {
        // ======================
        // SESSION VALUES
        // ======================
        $customer_id = Session::get('customer_id');
        $vendor_id   = Session::get('vendor_id');
        $supplier_id = Session::get('supplier_id');

        // ======================
        // DATA FETCH
        // ======================
        $credit_days = DB::table('credit_days')->get();
        $delivery_type = DB::table('delivery_type')->get();
        $maximum_distances = DB::table('maximum_distances')->get();
        $supplier_data = DB::table('supplier_reg')->get();
dd( $supplier_data);
        // ======================
        // LAYOUT SELECTION
        // ======================
        $layout = 'layouts.guest'; // default (NOT logged in)

        if (!empty($customer_id)) {
            $layout = 'layouts.custapp';
        } elseif (!empty($vendor_id)) {
            $layout = 'layouts.vendorapp';
        } elseif (!empty($supplier_id)) {
            $layout = 'layouts.guest';
        }

//         dd([
//     'customer' => $customer_id,
//     'vendor'   => $vendor_id,
//     'supplier' => $supplier_id,
//     'layout'   => $layout
// ]);

        // ======================
        // RETURN VIEW
        // ======================
        return view('web.supplierserch', compact(
            'credit_days',
            'delivery_type',
            'maximum_distances',
            'supplier_data',
            'layout',
            'customer_id',
            'vendor_id',
            'supplier_id'
        ));
    }

    public function supplierenquirystore(Request $request){
        // dd($request);
        $validated = $request->validate([
            'supplier_id'        => ['required','integer'],
            'category'           => ['nullable','string','max:255'],
            'quantity'           => ['nullable','string','max:100'],
            'specs'              => ['nullable','string'],
            'delivery_location'  => ['nullable','string','max:255'],
            'required_by'        => ['nullable','string','max:100'],
            'payment_preference' => ['required','in:cash,online,credit'],
            'attachments.*'      => ['nullable','file','max:5120'],
        ]);

        /* ===============================
           HANDLE FILE UPLOADS
        =============================== */
        $files = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $files[] = $file->store('enquiries/attachments', 'public');
            }
        }

        /* ===============================
           SAVE ENQUIRY
        =============================== */
        $enquiry = SupplierEnquiry::create([
            'supplier_id'        => $validated['supplier_id'],
            'category'           => $validated['category'] ?? null,
            'quantity'           => $validated['quantity'] ?? null,
            'specs'              => $validated['specs'] ?? null,
            'delivery_location'  => $validated['delivery_location'] ?? null,
            'required_by'        => $validated['required_by'] ?? null,
            'payment_preference' => $validated['payment_preference'],
            'attachments'        => $files ?: null,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Enquiry sent successfully',
            'id'      => $enquiry->id
        ]);
    }

    public function productenquiry(){
        $supplier_id = Session::get('supplier_id');
        // dd($supplier_id);
        $enquiries =DB::table('supplier_enquiries')->where('supplier_id', $supplier_id)->get();
        // dd($enquiries);
        return view('web.productenquiry',compact('enquiries'));
    }

}
