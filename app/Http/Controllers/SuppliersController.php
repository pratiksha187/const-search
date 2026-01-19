<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\SupplierEnquiry;
use Illuminate\Support\Facades\Storage;
use App\Models\Suppliers;
use App\Models\SupplierProductData;

class SuppliersController extends Controller
{

    public function mystore()
    {
        $supplier_id = Session::get('supplier_id');

        $supplierName = DB::table('supplier_reg')
            ->where('id', $supplier_id)
            ->value('contact_person');

        $supplier_data = DB::table('supplier_reg')
            ->where('id', $supplier_id)
            ->first(); // use first() instead of get()

        // Decode JSON category IDs
        $categoryIds = json_decode($supplier_data->material_category, true);

        // Fetch category names
        $categories = DB::table('material_categories')
            ->whereIn('id', $categoryIds)
            ->pluck('name');

        //  delivery_type   
        $delivery_type_id=$supplier_data->delivery_type;
        $delivery_type = DB::table('delivery_type')
            ->where('id', $delivery_type_id)
            ->value('type');
        $credit_days_id=$supplier_data->credit_days;
        $credit_days = DB::table('credit_days')
            ->where('id', $credit_days_id)
            ->value('days');  
            // dd($delivery_type);

            // experience_years
        $experience_years_id= $supplier_data->years_in_business;
        $experience_years = DB::table('experience_years')
            ->where('id', $experience_years_id)
            ->value('experiance'); 
            
        $maximum_distance_id = $supplier_data->maximum_distance;
        $maximum_distance = DB::table('maximum_distances')
            ->where('id', $maximum_distance_id)
            ->value('distance_km'); 
        // dd($experience_years);
        return view('web.mystore', compact(
            'supplierName','maximum_distance',
            'supplier_data','experience_years',
            'credit_days',
            'categories','delivery_type'
        ));
    }


    public function quotesandorder(){
         $supplier_id = Session::get('supplier_id');
        $supplierName = DB::table('supplier_reg')
                        ->where('id', $supplier_id)
                        ->value('contact_person'); 
        return view('web.quotes&order',compact('supplierName'));
    }
   
    public function myproducts(Request $request)
    {
        $supplier_id = Session::get('supplier_id');
        $supplierName = DB::table('supplier_reg')
                        ->where('id', $supplier_id)
                        ->value('contact_person'); 
        $query = DB::table('supplier_products_data as sp')
            ->leftJoin('material_categories as mc', 'mc.id', '=', 'sp.material_category_id')
            ->leftJoin('material_product as mp', 'mp.id', '=', 'sp.material_product_id')
            ->leftJoin('material_product_subtype as ms', 'ms.id', '=', 'sp.material_product_subtype_id')
            ->leftJoin('brands as b', 'b.id', '=', 'sp.brand_id')
            ->leftJoin('unit as u', 'u.id', '=', 'sp.unit_id')
            ->leftJoin('delivery_type as dt', 'dt.id', '=', 'sp.delivery_type_id')
            ->where('sp.supp_id', $supplier_id);

        /* 🔍 SEARCH (PRODUCT / BRAND) */
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('mp.product_name', 'like', '%'.$request->search.'%')
                ->orWhere('b.name', 'like', '%'.$request->search.'%');
            });
        }

        /* 🏷️ CATEGORY FILTER */
        if ($request->filled('category')) {
            $query->where('mc.name', $request->category);
        }

        /* 🧾 GST FILTER */
        if ($request->filled('gst')) {
            $query->where('sp.gst_included', $request->gst);
        }

        $products = $query->select(
                'sp.id',
                'mc.name as category',
                'mp.product_name as product',
                'ms.material_subproduct as subtype',
                'b.name as brand',
                'u.unitname as unit',
                'sp.price',
                'sp.gst_included',
                'sp.gst_percent',
                'dt.type as delivery_type',
                'sp.image',
                'sp.delivery_time',
                'sp.created_at'
            )
            ->orderBy('sp.id', 'desc')
            ->get();
        // dd($products);
        return view('web.myproducts', compact('products','supplierName'));
    }


    public function editProduct($id)
    {
        $supplier_id = Session::get('supplier_id');

        $product = DB::table('supplier_products_data')
            ->where('id', $id)
            ->where('supp_id', $supplier_id)
            ->first();

        if (!$product) {
            abort(404);
        }

        return view('web.productsuppedit', [
            'product' => $product,
            'categories' => DB::table('material_categories')->get(),
            'products' => DB::table('material_product')->get(),
            'subtypes' => DB::table('material_product_subtype')->get(),
            'brands' => DB::table('brands')->get(),
            'units' => DB::table('unit')->get(),
            'deliveryTypes' => DB::table('delivery_type')->get(),
        ]);
    }


     public function updateProduct(Request $request, $id)
    {
        $supplier_id = Session::get('supplier_id');

        $request->validate([
            'price' => 'required|numeric',
            'gst_percent' => 'nullable|numeric',
        ]);

        DB::table('supplier_products_data')
            ->where('id', $id)
            ->where('supp_id', $supplier_id)
            ->update([
                'price'         => $request->price,
                'gst_percent'   => $request->gst_percent,
                'gst_included'  => $request->gst_included ?? 0,
                'updated_at'    => now(),
            ]);

        return redirect()
            ->route('myproducts')
            ->with('success', 'Product updated successfully');
    }

    /* =========================================================
       4️⃣ DELETE PRODUCT
    ========================================================= */
    public function deleteProduct($id)
    {
         $supplier_id = Session::get('supplier_id');

        DB::table('supplier_products_data')
            ->where('id', $id)
            ->where('supp_id', $supplier_id)
            ->delete();

        return redirect()
            ->back()
            ->with('success', 'Product deleted successfully');
    }
//     private function calculateSupplierProfileCompletion($supplier)
// {
//     if (!$supplier) return 0;

//     $fields = [
//         'shop_name',
//         'contact_person',
//         'mobile',
//         'email',
//         'state_id',
//         'city_id',
//         'shop_address',
//         'gst_number',
//         'pan_number',
//         'material_category',
//         'bank_name',
//         'account_number',
//     ];

//     $filled = 0;

//     foreach ($fields as $field) {
//         if (!empty($supplier->$field)) {
//             $filled++;
//         }
//     }

//     return round(($filled / count($fields)) * 100);
// }

  
    // public function suppliersprofile()
    // {
    //     $states = DB::table('state')->orderBy('name')->get();

    //     $supplier_id = Session::get('supplier_id');

    //     $supplierName = DB::table('supplier_reg')
    //                     ->where('id', $supplier_id)
    //                     ->value('contact_person'); 
    //     //  dd( $supplier_id );
    //     $primary_type   = DB::table('materials')->get();
    //     $material_categories   = DB::table('material_categories')->get();
        
    //     $experience  = DB::table('years_in_business')->get();
    //     $delivery_type = DB::table('delivery_type')->get();
    //     $credit_days =DB::table('credit_days')->get();
    //     $maximum_distances =DB::table('maximum_distances')->get();
    //     // Example: get supplier by logged-in user
    //     $supplier = DB::table('supplier_reg')
    //                 ->where('id', $supplier_id)
    //                 ->first();
    //     // dd($material_categories);
    //     return view('web.suppliersprofile', compact(
    //         'supplierName',
    //         'material_categories',
    //         'primary_type',
    //         'experience',
    //         'supplier',
    //         'credit_days',
    //         'delivery_type',
    //         'maximum_distances',
    //         'states'
        
    //     ));
    // }
    public function suppliersprofile()
    {
        $supplier_id = Session::get('supplier_id');
        //mc_chemicals
        $mc_chemicals = DB::table('material_product')->where('material_id','5')->get();
        $units = DB::table('unit')->get();
        
        $thickness_size =DB::table('thickness_size')->get();
        $delivery_type = DB::table('delivery_type')->get();
        $designcode= DB::table('designcode')->get();
        
       // cementconcrete
        $cementconcrete	=DB::table('material_product')->where('material_id','1')->get();	

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
        // steeltmt
        $steeltmt	=DB::table('material_product')->where('material_id','2')->get();	

        // cement-concrete
        $cementconcrete	=DB::table('material_product')->where('material_id','1')->get();	
        
        // aggregatessand
        $aggregates	=DB::table('material_product')->where('material_id','28')->get();	

        // roadconstruction
        $roadconstruction	=DB::table('material_product')->where('material_id','29')->get();
        $states = DB::table('state')->orderBy('name')->get();

        $supplier = DB::table('supplier_reg')
                        ->where('id', $supplier_id)
                        ->first();
    
            // ================= PROFILE COMPLETION LOGIC =================
        $profileCompletion = 0;

        $profileSteps = [
            'basic'   => false,
            'material'=> false,
            'uploads' => false,
            'bank'    => false,
        ];

        // STEP 1: BASIC DETAILS
        if (
            !empty($supplier->shop_name) &&
            !empty($supplier->mobile) &&
            !empty($supplier->state_id) &&
            !empty($supplier->city_id)
        ) {
            $profileSteps['basic'] = true;
            $profileCompletion += 25;
        }

        // STEP 2: MATERIAL SELECTED
        if (!empty($supplier->material_category)) {
            $profileSteps['material'] = true;
            $profileCompletion += 25;
        }

        // STEP 3: DOCUMENT UPLOADS (MIN REQUIRED)
        if (
            !empty($supplier->gst_certificate_path) &&
            !empty($supplier->pan_card_path)
        ) {
            $profileSteps['uploads'] = true;
            $profileCompletion += 25;
        }

        // STEP 4: BANK DETAILS
        if (
            !empty($supplier->bank_name) &&
            !empty($supplier->account_number) &&
            !empty($supplier->ifsc_code)
        ) {
            $profileSteps['bank'] = true;
            $profileCompletion += 25;
        }

        $enabledCategoryTabs = [];

        if (!empty($supplier->material_category)) {

            // Decode JSON string like ["1","11"]
            $decoded = json_decode($supplier->material_category, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                // Convert values to integers (IMPORTANT)
                $enabledCategoryTabs = array_map('intval', $decoded);
            } else {
                // Fallback (comma-separated or single value)
                $enabledCategoryTabs = array_map(
                    'intval',
                    explode(',', trim($supplier->material_category, '[]"'))
                );
            }
        }

        // dd($selectedMaterialIds);
        $supplierName = $supplier?->contact_person;

        // 🔥 CALCULATE PROFILE COMPLETION
        // $profileCompletion = $this->calculateSupplierProfileCompletion($supplier);

        $primary_type = DB::table('materials')->get();
        $material_categories = DB::table('material_categories')->get();
        $experience = DB::table('years_in_business')->get();
        $delivery_type = DB::table('delivery_type')->get();
        $credit_days = DB::table('credit_days')->get();
        $maximum_distances = DB::table('maximum_distances')->get();

        return view('web.suppliersprofile', compact(
            'supplierName',
            'material_categories', 'profileCompletion',
            'profileSteps',
            'primary_type',
            'experience',
            'supplier',
            'credit_days',
            'delivery_type',
            'maximum_distances','enabledCategoryTabs',
            'states',
            // 'profileCompletion',
            'supplierName','thickness_size','mc_chemicals','units','delivery_type',
            'Plumbingmaterials','electricalitems','doorswindows','glassglazing','hardwaretools','machineries','timberwood','roofingmaterials','pavers',
            'concreteproducts','roadsafety','facadecladding','roadconstruction','scaffolding','hvacutilities','readymix','paintcoating','aggregates','tilesflooring','cementconcrete','designcode','steeltmt' // 👈 PASS TO VIEW
        ));
    }


    public function supplierstore(Request $request)
    {
        // dd($request);
        $supplier_id = Session::get('supplier_id');
      
        if (!$supplier_id) {
            return back()->with('error', 'Unauthorized');
        }

        /* ===============================
        VALIDATION
        =============================== */
        $validated = $request->validate([
            'shop_logo'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'shop_name'         => 'nullable',
            'contact_person'    => 'nullable',
            'mobile'             => 'nullable',
            'whatsapp'          => 'nullable',
            'email'             => 'nullable',
            'shop_address'      => 'nullable',
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
            'state_id'  => 'nullable',
            'region_id' => 'nullable',
            'city_id' => 'nullable',
            
            'material_category'   => 'nullable|array',
          

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
        SHOP LOGO UPLOAD
        =============================== */
        if ($request->hasFile('shop_logo')) {

            // delete old logo if exists
            if (!empty($supplier->shop_logo)) {
                \Storage::disk('public')->delete('supplier_logos/' . $supplier->shop_logo);
            }

            $logo = $request->file('shop_logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();

            $logo->storeAs('supplier_logos', $logoName, 'public');

            $supplier->shop_logo = $logoName;
        }

        // Save material categories as JSON
        if ($request->has('material_category')) {
            $supplier->material_category = json_encode($request->material_category);
        } else {
            $supplier->material_category = json_encode([]);
        }

        $supplier->fill([
            'shop_name'          => $validated['shop_name'] ?? null,
            'contact_person'     => $validated['contact_person'] ?? null,
            'mobile'             => $validated['mobile'] ?? null,
            'whatsapp'           => $validated['whatsapp'] ?? null,
            'email'              => $validated['email'] ?? null,
            'shop_address'       => $validated['shop_address'] ?? null,
            'city_id'            => $validated['city_id'] ?? null,
            'region_id'          => $validated['region_id'] ?? null,
            'state_id'           => $validated['state_id'] ?? null,
            'years_in_business'  => $validated['years_in_business'] ?? null,
            'gst_number'         => $validated['gst_number'] ?? null,
            'pan_number'         => $validated['pan_number'] ?? null,
            'msme_status'        => $validated['msme_status'] ?? null,
            'open_time'          => $validated['open_time'] ?? null,
            'close_time'         => $validated['close_time'] ?? null,
            'credit_days'        => $validated['credit_days'] ?? null,
            'delivery_type'      => $validated['delivery_type'] ?? null,
            'delivery_days'      => $validated['delivery_days'] ?? null,
            'minimum_order_cost' => $validated['minimum_order_cost'] ?? null,
            'maximum_distance'   => $validated['maximum_distance'] ?? null,
            'account_holder'     => $validated['account_holder'] ?? null,
            'bank_name'          => $validated['bank_name'] ?? null,
            'account_number'     => $validated['account_number'] ?? null,
            'ifsc_code'          => $validated['ifsc_code'] ?? null,
            'status'             => 'pending',
        ]);

        // ✅ ADD THIS
        $supplier->material_category = json_encode(
            $request->material_category ?? []
        );
        $supplier->save();

        return redirect()->back()->with('success', 'Supplier details updated successfully');
    }



    public function addproducts()
    {
        $supplier_id = Session::get('supplier_id');

        $supplierName = DB::table('supplier_reg')
                        ->where('id', $supplier_id)
                        ->value('contact_person'); 
        //mc_chemicals
        $mc_chemicals = DB::table('material_product')->where('material_id','5')->get();
        $units = DB::table('unit')->get();
        $thickness_size =DB::table('thickness_size')->get();
        $delivery_type = DB::table('delivery_type')->get();
        $designcode= DB::table('designcode')->get();
        
       // cementconcrete
        $cementconcrete	=DB::table('material_product')->where('material_id','1')->get();	

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
        // steeltmt
        $steeltmt	=DB::table('material_product')->where('material_id','2')->get();	

        // cement-concrete
        $cementconcrete	=DB::table('material_product')->where('material_id','1')->get();	
        
        // aggregatessand
        $aggregates	=DB::table('material_product')->where('material_id','28')->get();	

        // roadconstruction
        $roadconstruction	=DB::table('material_product')->where('material_id','29')->get();	

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
        $supplier_data_id =   DB::table('supplier_reg')
                        ->where('id', $supplier_id)->first();
                        // dd($supplier_data_id);
        $allowedCategories = json_decode($supplier_data_id->material_category, true); 
        return view('web.catalog.addproduct', compact('supplier','allowedCategories','supplierName','thickness_size', 'categories','mc_chemicals','units','delivery_type',
        'Plumbingmaterials','electricalitems','doorswindows','glassglazing','hardwaretools','machineries','timberwood','roofingmaterials','pavers',
        'concreteproducts','roadsafety','facadecladding','roadconstruction','scaffolding','hvacutilities','readymix','paintcoating','aggregates','tilesflooring','cementconcrete','designcode','steeltmt'));
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
    $notificationCount =0;
    $notifications =0;
    $customer_id = Session::get('customer_id');
    $cust_data = DB::table('users')->where('id',$customer_id)->first();
    $vendor_id   = Session::get('vendor_id');
    $supplier_id = Session::get('supplier_id');
    // dd($customer_id);
    /* ===============================
       MASTER DATA
    =============================== */
    $credit_days       = DB::table('credit_days')->get();
    $delivery_type     = DB::table('delivery_type')->get();
    $maximum_distances = DB::table('maximum_distances')->get();
    $material_categories = DB::table('material_categories')->get();
    // dd($credit_days);
    /* ===============================
       SUPPLIERS + CATEGORIES
    =============================== */
    $supplier_data = DB::table('supplier_reg as s')
        ->leftJoin('supplier_products_data as sp', 'sp.supp_id', '=', 's.id')
        ->leftJoin('material_categories as mc', 'mc.id', '=', 'sp.material_category_id')
        ->leftJoin('credit_days as cd', 'cd.id', '=', 's.credit_days')
        ->select(
            's.*',
            'cd.days as credit_days_value',
            DB::raw('GROUP_CONCAT(DISTINCT mc.id ORDER BY mc.id) as material_category_ids'),
            DB::raw('GROUP_CONCAT(DISTINCT mc.name ORDER BY mc.name) as material_category_names')
        )
        ->groupBy('s.id', 'cd.days')
        ->orderBy('s.id', 'desc')
        ->get();

    /* ===============================
       NORMALIZE CATEGORY DATA
    =============================== */
    foreach ($supplier_data as $supplier) {

        $ids   = $supplier->material_category_ids
            ? explode(',', $supplier->material_category_ids)
            : [];

        $names = $supplier->material_category_names
            ? explode(',', $supplier->material_category_names)
            : [];

        $supplier->material_categories = [];

        foreach ($ids as $i => $id) {
            $supplier->material_categories[] = [
                'id'   => (int) $id,
                'name' => $names[$i] ?? null
            ];
        }

        unset($supplier->material_category_ids, $supplier->material_category_names);
    }

    /* ===============================
       ✅ FETCH VENDOR IF LOGGED IN
    =============================== */
    $vendor = null;

    if ($vendor_id) {
        $vendor = DB::table('vendor_reg')
            ->where('id', $vendor_id)
            ->first();
    }

    /* ===============================
       LAYOUT
    =============================== */
    $layout = 'layouts.guest';
    if ($customer_id) {
       
        $postIds = DB::table('posts')
                    ->where('user_id', $customer_id)
                    ->pluck('id');
        $notifications = DB::table('vendor_interests as vi')
                // ->join('vendor_reg as v', 'v.id', '=', 'vi.vendor_id')
                ->whereIn('vi.customer_id', $postIds)
            
                ->get();
        $notificationCount = $notifications->count();
        $layout = 'layouts.custapp';
    } elseif ($vendor_id) {
        // $vendor = DB::table('vendor_reg')
        //             ->where('id', $vendor_id)
        //             ->first();
        $vendIds = DB::table('vendor_reg')
                    ->where('id', $vendor_id)
                    ->pluck('id');
    //    dd( $vendIds );
        $notifications = DB::table('customer_interests as ci')
                ->join('users as u', 'u.id', '=', 'ci.customer_id')
                ->whereIn('ci.vendor_id', $vendIds)
                // ->select('v.*','vi.*')
                 ->select('ci.*','u.*')
                ->get();
        //    dd( $notifications );     
        $notificationCount = $notifications->count();
        // dd('tsest');
        $layout = 'layouts.vendorapp';
    }

    $brands = DB::table('brands')
          
            ->orderBy('name')
            ->get();
    // ✅ LOGIN CHECK FLAG
    $isLoggedIn = false;

    if ($customer_id || $vendor_id) {
        $isLoggedIn = true;
    }


    // dd($supplier_data);
    return view('web.supplierserch', compact(
        'credit_days','material_categories','notificationCount','notifications',
        'delivery_type',
        'maximum_distances',
        'supplier_data',
        'layout','cust_data',
        'customer_id',
        'brands',
        'vendor_id',
        'supplier_id',
        'isLoggedIn',
        'vendor' 
    ));
}

public function supplierFilter(Request $request)
{
    $query = DB::table('supplier_reg as s')
        ->leftJoin('supplier_products_data as sp', 'sp.supp_id', '=', 's.id')
        ->leftJoin('material_categories as mc', 'mc.id', '=', 'sp.material_category_id')
        ->leftJoin('credit_days as cd', 'cd.id', '=', 's.credit_days')
        ->select(
            's.*',
            'cd.days as credit_days_value',
            DB::raw('GROUP_CONCAT(DISTINCT mc.id) as material_category_ids'),
            DB::raw('GROUP_CONCAT(DISTINCT mc.name) as material_category_names')
        );

    // ✅ SEARCH FILTER
    if ($request->filled('search')) {
        $search = $request->search;

        // $query->where(function ($q) use ($search) {
        //     $q->where('s.shop_name', 'LIKE', "%{$search}%")
        //       ->orWhere('s.city', 'LIKE', "%{$search}%")
        //       ->orWhere('s.area', 'LIKE', "%{$search}%")
        //       ->orWhere('mc.name', 'LIKE', "%{$search}%");
        // });
        // ✅ SAFE SEARCH
        $query->where(function ($q) use ($search) {
            $q->where('s.shop_name', 'LIKE', "%{$search}%")
            ->orWhere('mc.name', 'LIKE', "%{$search}%");
        });

    }

    // ✅ CATEGORY FILTER
    if ($request->filled('categories')) {
        $query->whereIn('sp.material_category_id', $request->categories);
    }

    // ✅ CREDIT FILTER
    if ($request->filled('credit_terms')) {
        $query->whereIn('s.credit_days', $request->credit_terms);
    }

    $supplier_data = $query
        ->groupBy('s.id', 'cd.days')
        ->orderBy('s.id', 'desc')
        ->get();

    foreach ($supplier_data as $supplier) {
        $supplier->material_categories = [];

        if ($supplier->material_category_ids) {
            $ids   = explode(',', $supplier->material_category_ids);
            $names = explode(',', $supplier->material_category_names);

            foreach ($ids as $i => $id) {
                $supplier->material_categories[] = [
                    'id' => $id,
                    'name' => $names[$i] ?? ''
                ];
            }
        }
    }

    return view('web.supplier_cards', compact('supplier_data'))->render();
}


    public function supplierenquirystore(Request $request)
{
    /* ===============================
       🔐 LOGIN CHECK (VERY IMPORTANT)
    =============================== */
    if (!session()->has('customer_id') && !session()->has('vendor_id')) {
        return response()->json([
            'status'  => false,
            'message' => 'Login required'
        ], 401);
    }

    $userId = session('customer_id') ?? session('vendor_id');

    /* ===============================
       VALIDATION
    =============================== */
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
       📎 HANDLE FILE UPLOADS
    =============================== */
    $files = [];

    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $files[] = $file->store('enquiries/attachments', 'public');
        }
    }

    /* ===============================
       💾 SAVE ENQUIRY
    =============================== */
    $enquiry = SupplierEnquiry::create([
        'supplier_id'        => $validated['supplier_id'],
        'user_id'            => $userId, // ✅ IMPORTANT
        'category'           => $validated['category'] ?? null,
        'quantity'           => $validated['quantity'] ?? null,
        'specs'              => $validated['specs'] ?? null,
        'delivery_location'  => $validated['delivery_location'] ?? null,
        'required_by'        => $validated['required_by'] ?? null,
        'payment_preference' => $validated['payment_preference'],
        'attachments'        => !empty($files) ? json_encode($files) : null,
    ]);

    return response()->json([
        'status'  => true,
        'message' => 'Enquiry sent successfully',
        'id'      => $enquiry->id
    ]);
}


    public function productenquiry()
    {
        $supplier_id = Session::get('supplier_id');
        $supplierName = DB::table('supplier_reg')
                            ->where('id', $supplier_id)
                        ->value('contact_person'); 
        $enquiries = DB::table('supplier_enquiries as se')
            ->join('supplier_reg as sr', 'se.supplier_id', '=', 'sr.id')
            ->join('material_categories as mc', 'se.category', '=', 'mc.id')

            
            ->where('se.supplier_id', $supplier_id)
            ->select(
                'se.*',
                'sr.contact_person',
                'sr.shop_name', // Add any other supplier columns you need
                'sr.mobile',
                'sr.email',
                'mc.name as material_categories_name'
            )
            ->get();

        // dd($enquiries); // Check the result
        return view('web.productenquiry', compact('enquiries','supplierName'));
    }

   
   
    public function storeSupplierProductData(Request $request)
    {
        $supp_id = session('supplier_id'); // keep as-is if working
        // dd($request );
        // ✅ FIXED VALIDATION (MATCH REQUEST)
        $request->validate([
            'material_category_id' => 'required',
            'product_type'         => 'required',
            'product_subtype'      => 'nullable',
            'brand'                => 'nullable',
            'unit'                 => 'required',
            'price'                => 'nullable|numeric',
            'gst'                  => 'nullable|numeric',
            'delivery_time'        => 'nullable',
            'product_image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ✅ IMAGE UPLOAD
        $imageName = null;
        if ($request->hasFile('product_image')) {
            $imageName = time().'_'.$request->product_image->getClientOriginalName();
            $request->product_image->move(
                public_path('uploads/products'),
                $imageName
            );
        }

        // ✅ SAVE DATA (PROPER MAPPING)
        SupplierProductData::create([
            'supp_id'                     => $supp_id,
            'material_category_id'        => $request->material_category_id,
            'material_product_id'         => $request->product_type,
            'material_product_subtype_id' => $request->product_subtype,
            'brand_id'                    => $request->brand,
            'unit_id'                     => $request->unit,
            'price'                       => $request->price,
            'gst_percent'                 => $request->gst, 
            'gst_included'                => $request->has('gst_included') ? 1 : 0,
            'delivery_time'               => $request->delivery_time,
            'delivery_type_id'            => $request->delivery_type,
            'image'                       => $imageName,
        ]);

        // return back()->with('success', 'Product saved successfully!');
        return back()->with('success', 'Product added successfully!');

        //  return redirect()->route('myproducts')
        //              ->with('success', 'Product saved successfully!');
    }


    public function supplierprofileid($id)
    {
        $notificationCount =0;
        $notifications =0;
        $customer_id = Session::get('customer_id');
        $vendor_id   = Session::get('vendor_id');
        $supplier_id = Session::get('supplier_id');

       
        $layout = 'layouts.guest';
        if ($customer_id) {
            $cust_data = DB::table('users')->where('id',$customer_id)->first();
            $postIds = DB::table('posts')
                    ->where('user_id', $customer_id)
                    ->pluck('id');
            $notifications = DB::table('vendor_interests as vi')
                    // ->join('vendor_reg as v', 'v.id', '=', 'vi.vendor_id')
                    ->whereIn('vi.customer_id', $postIds)
                
                    ->get();
            $notificationCount = $notifications->count();
            $layout = 'layouts.custapp';
        } elseif ($vendor_id) {
            $cust_data = DB::table('vendor_reg')->where('id',$vendor_id)->first();
            $vendor = DB::table('vendor_reg')
                    ->where('id', $vendor_id)
                    ->first();
            $vendIds = DB::table('vendor_reg')
                    ->where('id', $vendor_id)
                    ->pluck('id');
        //    dd( $vendIds );
            $notifications = DB::table('customer_interests as ci')
                    ->join('users as u', 'u.id', '=', 'ci.customer_id')
                    ->whereIn('ci.vendor_id', $vendIds)
                    // ->select('v.*','vi.*')
                    ->select('ci.*','u.*')
                    ->get();
            //    dd( $notifications );     
            $notificationCount = $notifications->count();
            $layout = 'layouts.vendorapp';
        }


        // dd( $layout );
        $supplier = DB::table('supplier_reg as s')
            ->leftJoin('credit_days as cd', 'cd.id', '=', 's.credit_days')
            ->leftJoin('city as c', 'c.id', '=', 's.city_id')
            ->leftJoin('region as r', 'r.id', '=', 's.region_id')
            ->leftJoin('state as sn', 'sn.id', '=', 's.state_id')

            ->select(
                's.*','c.name as cityname','r.name as regionname','sn.name as statename',
                'cd.days as credit_days_value'
            )
            ->where('s.id', $id)
            ->first();

        if (!$supplier) {
            abort(404);
        }
        // dd( $supplier );
        // Supplier categories / products
        $materials = DB::table('supplier_products_data as sp')
            ->leftJoin('material_categories as mc', 'mc.id', '=', 'sp.material_category_id')
            ->where('sp.supp_id', $id)
            ->pluck('mc.name');
        // dd( $materials);
        return view('web.supplier_profile', compact('supplier', 'materials','layout','cust_data','vendor' ,'vendor_id','notifications','notificationCount'));
    }

}
