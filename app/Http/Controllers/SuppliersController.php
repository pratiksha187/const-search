<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\SupplierEnquiry;
use App\Models\Suppliers;
use App\Models\SupplierProductData;

class SuppliersController extends Controller
{
  
    public function suppliersprofile()
    {
        $states = DB::table('state')->orderBy('name')->get();

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
            'maximum_distances',
            'states'
        
        ));
    }


    public function supplierstore(Request $request)
    {
        
        $supplier_id = Session::get('supplier_id');
      
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



    public function addproducts()
    {
        $supplier_id = Session::get('supplier_id');
        //mc_chemicals
        $mc_chemicals = DB::table('material_product')->where('material_id','5')->get();
        $units = DB::table('unit')->get();
        $thickness_size =DB::table('thickness_size')->get();
        $delivery_type = DB::table('delivery_type')->get();
        $designcode= DB::table('designcode')->get();
        

        //Plumbing Materials					
        $Plumbingmaterials = DB::table('material_product')->where('material_id','6')->get();					

        //Electrical Items
        $electricalitems =DB::table('material_product')->where('material_id','7')->get();	
         //doorswindows
        $doorswindows =DB::table('material_product')->where('material_id','8')->get();
        // glassglazing
        $glassglazing =DB::table('material_product')->where('material_id','9')->get();	

        // hardwaretools
        $hardwaretools =DB::table('material_product')->where('material_id','10')->get();	

        // machineries
        $machineries =DB::table('material_product')->where('material_id','11')->get();	

        // timberwood
        $timberwood =DB::table('material_product')->where('material_id','12')->get();	

        // Roofing Materials 
        $roofingmaterials =DB::table('material_product')->where('material_id','13')->get();	

        // Pavers & Kerbstones	
        $pavers	=DB::table('material_product')->where('material_id','14')->get();	

        // concreteproducts
        $concreteproducts	=DB::table('material_product')->where('material_id','15')->get();	

        // roadsafety
        $roadsafety	=DB::table('material_product')->where('material_id','16')->get();	

         // Facade & Cladding Materials
        $facadecladding	=DB::table('material_product')->where('material_id','17')->get();	

         // Facade & Cladding Materials
        $scaffolding	=DB::table('material_product')->where('material_id','18')->get();	

          // HVAC & Utilities
        $hvacutilities	=DB::table('material_product')->where('material_id','19')->get();	

        //readymix
        $readymix	=DB::table('material_product')->where('material_id','20')->get();	

        // Paint & Coatings	
        $paintcoating	=DB::table('material_product')->where('material_id','21')->get();	
        // tilesflooring
        $tilesflooring	=DB::table('material_product')->where('material_id','22')->get();	


        // Supplier (as you already have)
        $supplier = DB::table('supplier_products')
            ->where('supplier_id', $supplier_id)
            ->first();

        // ✅ Fetch material categories dynamically
        $categories = DB::table('material_categories')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();
            // dd($categories->slug);

        return view('web.catalog.addproduct', compact('supplier','thickness_size', 'categories','mc_chemicals','units','delivery_type',
        'Plumbingmaterials','electricalitems','doorswindows','glassglazing','hardwaretools','machineries','timberwood','roofingmaterials','pavers',
        'concreteproducts','roadsafety','facadecladding','scaffolding','hvacutilities','readymix','paintcoating','tilesflooring','designcode'));
    }

    public function getProductMeta($productId)
    {
        $subtypes = DB::table('material_product_subtype')
            ->where('material_product_id', $productId)
            ->orderBy('material_subproduct')
            ->get(['id', 'material_subproduct']);

        $brands = DB::table('brands')
            ->where('material_product_id', $productId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'subtypes' => $subtypes,
            'brands'   => $brands
        ]);
    }
    // public function getProductSubtypes($productId)
    // {
    //     return DB::table('material_product_subtype')
    //         ->where('material_product_id', $productId)
    //         ->orderBy('material_subproduct')
    //         ->get(['id', 'material_subproduct']);
    // }

    // public function getBrands($productId)
    // {
    //     // dd($productId);
    //     return DB::table('brands')
    //         ->where('material_product_id', $productId)
    //         ->orderBy('name')
    //         ->get(['id', 'name']);
    // }

    // public function getProfileTypes($subCategoryId)
    // {
    //     $profiles = DB::table('profiletype')
    //         ->where('sub_categories_id', $subCategoryId)
    //         ->orderBy('sub_categories_id')
    //         ->get(['id', 'type']);

    //     return response()->json($profiles);
    // }

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
        // dd( $supplier_data);
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

    public function storeSupplierProductData(Request $request)
    {

        dd($request);
        // Basic validation
        $request->validate([
            'product_type'    => 'required',
            'unit'            => 'required',
            'price'           => 'nullable|numeric',
            'gst_percent'     => 'nullable|numeric',
            'product_image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Image upload
        $imageName = null;
        if ($request->hasFile('product_image')) {
            $imageName = time() . '_' .
                $request->product_image->getClientOriginalName();

            $request->product_image->move(
                public_path('uploads/products'),
                $imageName
            );
        }

        // Save product
        SupplierProductData::create([
            'material_category_id'        =>$request->material_category_id,
            'material_product_id'         => $request->product_type,
            'material_product_subtype_id' => $request->product_subtype,
            'brand_id'                    => $request->brand,
            'unit_id'                     => $request->unit,
            'price'                       => $request->price,
            'gst_included'                => $request->gst_included ? 1 : 0,
            'gst_percent'                 => $request->gst_percent,
            'delivery_type_id'            => $request->delivery_type,
            'image'                       => $imageName,
        ]);

        return back()->with('success', 'Product saved successfully!');
    }
}
