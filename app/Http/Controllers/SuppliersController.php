<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\SupplierEnquiry;
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


    public function supplierstore(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'user_id'           => ['required', 'integer'], 
            // Basic info
            'shop_name'         => ['required', 'string', 'max:255'],
            'contact_person'    => ['required', 'string', 'max:255'],
            'phone'             => ['required', 'string', 'max:20'],
            'whatsapp'          => ['nullable', 'string', 'max:20'],
            'email'             => ['required', 'email', 'max:255'],
            'shop_address'      => ['required', 'string'],

            // City/Area
            'city'              => ['nullable'],
            'area'              => ['nullable'],

            // Business
            'primary_type'      => ['nullable'],
            'years_in_business' => ['nullable'],

            // PAN & GST
            'gst_number'        => ['nullable'],
            'pan_number'        => ['nullable'],
            'msme_status'       => ['nullable'],

            // Products & Categories
            'open_time'        => ['nullable'],
            'close_time.*'     => ['nullable'],
            'credit_days'      => ['nullable'],

          
            'minimum_order_cost' => ['nullable'],
            'delivery_days' => ['nullable'],
            'delivery_type' => ['nullable'],
            'distance_km' => ['nullable'],
            'maximum_distance' => ['nullable'],
            

            // Brands
            'brands_supplied'   => ['nullable', 'string'],

            // Pricing
            'price'             => ['nullable', 'numeric', 'min:0'],
            'discount_price'    => ['nullable', 'numeric', 'min:0'],
            'gst_percent'       => ['nullable', 'numeric', 'min:0', 'max:100'],

            // Service areas
            'service_areas'     => ['nullable', 'array'],
            'service_areas.*'   => ['string', 'max:100'],

            // Files
            'gst_certificate'   => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'pan_card'          => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'shop_license'      => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'sample_invoice'    => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'costing_sheet'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],

            // Images
            'images'            => ['nullable', 'array'],
            'images.*'          => ['file', 'image', 'max:5120'],

            // Bank
            'account_holder'    => ['required', 'string', 'max:255'],
            'bank_name'         => ['required', 'string', 'max:255'],
            'account_number'    => ['required', 'string', 'max:64'],
            'ifsc_code'         => ['required', 'string', 'max:20'],

            // Agreement
            'confirm_details'   => ['accepted'],
            'agree_terms'       => ['accepted'],
        ], [
            'gst_number.regex'  => 'Enter a valid GST number (e.g., 22AAAAA0000A1Z5).',
            'pan_number.regex'  => 'Enter a valid PAN number (e.g., ABCDE1234F).',
        ]);

        // Handle file uploads
        $docs = [];
        foreach (['gst_certificate', 'pan_card', 'shop_license', 'sample_invoice', 'costing_sheet'] as $docField) {
            if ($request->hasFile($docField)) {
                $docs[$docField] = $request->file($docField)->store("products/docs", 'public');
            }
        }

        // Handle multiple images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $imagePaths[] = $img->store("products/images", 'public');
            }
        }
        // $user_id=  $validated['user_id'];
        $supplier_id = Session::get('supplier_id');
      

       $product = Suppliers::create([
                'user_id'             => $user_id,

                // Basic
                'shop_name'           => $validated['shop_name'],
                'contact_person'      => $validated['contact_person'],
                'phone'               => $validated['phone'],
                'whatsapp'            => $validated['whatsapp'] ?? null,
                'email'               => $validated['email'],
                'shop_address'        => $validated['shop_address'],
                'city_id'             => $validated['city'],
                'area_id'             => $validated['area'],

                // Business
                'primary_type'        => $validated['primary_type'] ?? null,
                'years_in_business'   => $validated['years_in_business'] ?? null,
                'gst_number'          => $validated['gst_number'],
                'pan_number'          => $validated['pan_number'],
                'msme_status'         => $validated['msme_status'] ?? null,

                // Delivery & Credit
                'open_time'           => $validated['open_time'] ?? null,
                'close_time'          => $validated['close_time'] ?? null,
                'credit_days'         => $validated['credit_days'] ?? null,
                'delivery_type'       => $validated['delivery_type'] ?? null,
                'delivery_days'       => $validated['delivery_days'] ?? null,
                'minimum_order_cost'  => $validated['minimum_order_cost'] ?? null,
                'maximum_distance'    => $validated['maximum_distance'] ?? null,

                // Files
                'gst_certificate_path'=> $docs['gst_certificate'] ?? null,
                'pan_card_path'       => $docs['pan_card'] ?? null,
                'shop_license_path'   => $docs['shop_license'] ?? null,
                'sample_invoice_path' => $docs['sample_invoice'] ?? null,
                'costing_sheet'       => $docs['costing_sheet'] ?? null,

                // Images
                'images'              => $imagePaths ? json_encode($imagePaths) : null,

                // Bank
                'account_holder'      => $validated['account_holder'],
                'bank_name'           => $validated['bank_name'],
                'account_number'      => $validated['account_number'],
                'ifsc_code'           => $validated['ifsc_code'],
            ]);

        $product->save();

        // Return JSON response for AJAX, or redirect normally
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'message'  => 'Product created successfully.',
                'id'       => $product->id,
                'redirect' => route('products.create'),
            ]);
        }

        return redirect()->route('products.create')->with('success', 'Product created successfully.');
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

    public function supplierserch(){
        $credit_days =DB::table('credit_days')->get();
        $delivery_type =DB::table('delivery_type')->get();
        $maximum_distances =DB::table('maximum_distances')->get();
        $supplier_data = DB::table('supplier_reg')->get();
        // dd($supplier_data);
        return view('web.supplierserch',compact('credit_days','delivery_type','maximum_distances','supplier_data'));
    }


    public function supplierenquirystore(Request $request){
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
