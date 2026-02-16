<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\SupplierEnquiry;
use Illuminate\Support\Facades\Storage;
use App\Models\Suppliers;
use App\Models\SupplierProductData;
use Illuminate\Support\Facades\Mail;

class SuppliersController extends Controller
{

  
    public function mystore()
    {
        $supplier_id = Session::get('supplier_id');

        // 🔴 SAFETY CHECK 1: Supplier login
        if (!$supplier_id) {
            abort(403, 'Supplier not logged in');
        }

        // 🔹 Supplier name
        $supplierName = DB::table('supplier_reg')
            ->where('id', $supplier_id)
            ->value('contact_person');

        // 🔹 Supplier full data
        $supplier_data = DB::table('supplier_reg')
            ->leftJoin('region', 'region.id', '=', 'supplier_reg.region_id')
            ->leftJoin('city', 'city.id', '=', 'supplier_reg.city_id')
            ->leftJoin('state', 'state.id', '=', 'supplier_reg.state_id')
            ->leftJoin('years_in_business', 'years_in_business.id', '=', 'supplier_reg.years_in_business')
            ->where('supplier_reg.id', $supplier_id)
            ->select(
                'supplier_reg.*',
                'region.name as regionname',
                'city.name as cityname',
                'state.name as statename',
                'years_in_business.years as experiance_yer'
            )
            ->first();

        // 🔴 SAFETY CHECK 2: Supplier exists
        if (!$supplier_data) {
            abort(404, 'Supplier record not found');
        }

        /* ================= MATERIAL CATEGORIES ================= */
        $categories = collect();

        if (!empty($supplier_data->material_category)) {
            $categoryIds = json_decode($supplier_data->material_category, true);

            if (is_array($categoryIds)) {
                $categories = DB::table('material_categories')
                    ->whereIn('id', $categoryIds)
                    ->pluck('name');
            }
        }

        /* ================= DELIVERY TYPE ================= */
        $delivery_type = null;
        if (!empty($supplier_data->delivery_type)) {
            $delivery_type = DB::table('delivery_type')
                ->where('id', $supplier_data->delivery_type)
                ->value('type');
        }

        /* ================= CREDIT DAYS ================= */
        $credit_days = null;
        if (!empty($supplier_data->credit_days)) {
            $credit_days = DB::table('credit_days')
                ->where('id', $supplier_data->credit_days)
                ->value('days');
        }

        /* ================= MAX DISTANCE ================= */
        $maximum_distance = null;
        if (!empty($supplier_data->maximum_distance)) {
            $maximum_distance = DB::table('maximum_distances')
                ->where('id', $supplier_data->maximum_distance)
                ->value('distance_km');
        }

        return view('web.mystore', compact(
            'supplierName',
            'supplier_data',
            'categories',
            'delivery_type',
            'credit_days',
            'maximum_distance'
        ));
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
                'sp.price','sp.quntity',
                'sp.gst_included',
                'sp.gst_percent',
                'dt.type as delivery_type',
                'sp.image',
                'sp.delivery_time',
                'sp.created_at'
            )
            ->orderBy('sp.id', 'desc')
            ->paginate(10)   // 🔥 THIS ENABLES PAGINATION
            ->withQueryString(); // keeps filters while paging
            // ->get();
        // dd($products);
        return view('web.myproducts', compact('products','supplierName'));
    }


    public function editProduct($id)
    {
        $notificationCount =0;
        $notifications =0;
        $supplier_id = Session::get('supplier_id');

        $supplierName = DB::table('supplier_reg')
                        ->where('id', $supplier_id)
                        ->value('contact_person'); 
        $product = DB::table('supplier_products_data')
            ->where('id', $id)
            ->where('supp_id', $supplier_id)
            ->first();

        if (!$product) {
            abort(404);
        }

        return view('web.productsuppedit', [
            'product' => $product,
            'supplierName' => $supplierName,
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
//  dd($supplier_id);
        DB::table('supplier_products_data')
            ->where('id', $id)
            ->where('supp_id', $supplier_id)
            ->delete();

        return redirect()
            ->back()
            ->with('success', 'Product deleted successfully');
    }

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
    // dd($supplier);
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
        // dd( $experience);
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
        $notificationCount = 0;
        $notifications = collect();

        $customer_id  = Session::get('customer_id');
        $cust_data    = $customer_id ? DB::table('users')->where('id', $customer_id)->first() : null;

        $vendor_id    = Session::get('vendor_id');
        $supplier_id  = Session::get('supplier_id');

        /* ===============================
        MASTER DATA
        =============================== */
        $credit_days         = DB::table('credit_days')->get();
        $states              = DB::table('state')->orderBy('name')->get();
        $delivery_type       = DB::table('delivery_type')->get();
        $maximum_distances   = DB::table('maximum_distances')->get();
        $material_categories = DB::table('material_categories')->get();

        /* ===============================
        SUPPLIERS + CATEGORIES
        =============================== */
        $supplier_data = DB::table('supplier_reg as s')
            ->leftJoin('supplier_products_data as sp', 'sp.supp_id', '=', 's.id')
            ->leftJoin('material_categories as mc', 'mc.id', '=', 'sp.material_category_id')
            ->leftJoin('credit_days as cd', 'cd.id', '=', 's.credit_days')
            ->leftJoin('city as c', 'c.id', '=', 's.city_id')
            ->leftJoin('region as r', 'r.id', '=', 's.region_id')
            ->leftJoin('state as sn', 'sn.id', '=', 's.state_id')
            ->select(
                's.*',
                'cd.days as credit_days_value',
                'c.name as cityname',
                'r.name as regionname',
                'sn.name as statename',
                DB::raw('GROUP_CONCAT(DISTINCT mc.id ORDER BY mc.id) as material_category_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT mc.name ORDER BY mc.name) as material_category_names')
            )
            ->groupBy('s.id', 'cd.days', 'c.name', 'r.name', 'sn.name')
            ->orderBy('s.id', 'desc')
            ->get();

        /* ===============================
        NORMALIZE CATEGORY DATA + PROFILE COMPLETION PER SUPPLIER ✅
        =============================== */
        foreach ($supplier_data as $supplier) {

            // ---- normalize categories ----
            $ids   = $supplier->material_category_ids ? explode(',', $supplier->material_category_ids) : [];
            $names = $supplier->material_category_names ? explode(',', $supplier->material_category_names) : [];

            $supplier->material_categories = [];
            foreach ($ids as $i => $id) {
                $supplier->material_categories[] = [
                    'id'   => (int) $id,
                    'name' => $names[$i] ?? null
                ];
            }

            unset($supplier->material_category_ids, $supplier->material_category_names);

            // ---- profile completion ----
            $profileCompletion = 0;

            // STEP 1: BASIC DETAILS
            if (
                !empty($supplier->contact_person) &&
                !empty($supplier->mobile) &&
                !empty($supplier->email) &&
                !empty($supplier->shop_name)
            ) {
                $profileCompletion += 25;
            }

            // STEP 2: MATERIAL SELECTED (✅ correct)
            if (!empty($supplier->material_categories) && count($supplier->material_categories) > 0) {
                $profileCompletion += 25;
            }

            // STEP 3: DOCS + GST/PAN
            if (
                !empty($supplier->gst_certificate_path) &&
                !empty($supplier->pan_card_path) &&
                !empty($supplier->gst_number) &&
                !empty($supplier->pan_number)
            ) {
                $profileCompletion += 25;
            }

            // STEP 4: BANK
            if (
                !empty($supplier->bank_name) &&
                !empty($supplier->account_number) &&
                !empty($supplier->ifsc_code)
            ) {
                $profileCompletion += 25;
            }

            $supplier->profileCompletion = $profileCompletion;

            // badge
            $profileBadge = ['label' => 'Incomplete', 'class' => 'incomplete'];

            if ($profileCompletion >= 100) {
                $profileBadge = ['label' => 'Verified', 'class' => 'verified'];
            } elseif ($profileCompletion >= 75) {
                $profileBadge = ['label' => 'Trusted', 'class' => 'trusted'];
            } elseif ($profileCompletion >= 50) {
                $profileBadge = ['label' => 'Partially Verified', 'class' => 'partial'];
            }

            $supplier->profileBadge = $profileBadge;
        }

        /* ===============================
        ✅ FETCH VENDOR IF LOGGED IN
        =============================== */
        $vendor = null;
        if ($vendor_id) {
            $vendor = DB::table('vendor_reg')->where('id', $vendor_id)->first();
        }

        /* ===============================
        LAYOUT + NOTIFICATIONS
        =============================== */
        $layout = 'layouts.guest';

        if ($customer_id) {
            $postIds = DB::table('posts')->where('user_id', $customer_id)->pluck('id');

            $notifications = DB::table('vendor_interests as vi')
                ->whereIn('vi.customer_id', $postIds)
                ->get();

            $notificationCount = $notifications->count();
            $layout = 'layouts.custapp';

        } elseif ($vendor_id) {

            $vendIds = DB::table('vendor_reg')->where('id', $vendor_id)->pluck('id');

            $notifications = DB::table('customer_interests as ci')
                ->join('users as u', 'u.id', '=', 'ci.customer_id')
                ->whereIn('ci.vendor_id', $vendIds)
                ->select('ci.*', 'u.*')
                ->get();

            $notificationCount = $notifications->count();
            $layout = 'layouts.vendorapp';
        }

        $brands = DB::table('brands')->orderBy('name')->get();
        $isLoggedIn = ($customer_id || $vendor_id) ? true : false;

        return view('web.supplierserch', compact(
            'credit_days',
            'material_categories',
            'notificationCount',
            'notifications',
            'delivery_type',
            'maximum_distances',
            'states',
            'supplier_data',
            'layout',
            'cust_data',
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
            ->leftJoin('city as c', 'c.id', '=', 's.city_id')
                ->leftJoin('region as r', 'r.id', '=', 's.region_id')
                ->leftJoin('state as sn', 'sn.id', '=', 's.state_id')
            ->select(
                's.*','c.name as cityname','r.name as regionname','sn.name as statename',
                'cd.days as credit_days_value',
                DB::raw('GROUP_CONCAT(DISTINCT mc.id) as material_category_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT mc.name) as material_category_names')
            );

        // ✅ SEARCH FILTER
        if ($request->filled('search')) {
            $search = $request->search;

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
        if ($request->filled('state_id')) {
            $query->where('s.state_id', $request->state_id);
        }

        if ($request->filled('region_id')) {
            $query->where('s.region_id', $request->region_id);
        }

        if ($request->filled('city_id')) {
            $query->where('s.city_id', $request->city_id);
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
   
    public function storeSupplierProductData(Request $request)
    {
        // dd($request );
        $supp_id = session('supplier_id'); // keep as-is if working
       
        // ✅ FIXED VALIDATION (MATCH REQUEST)
        $request->validate([
            'material_category_id' => 'required',
            'product_type'         => 'required',
            'product_subtype'      => 'nullable',
            'brand'                => 'nullable',
            'unit'                 => 'required',
            'quntity'               => 'nullable',
            'price'                => 'nullable|numeric',
            'gst'                  => 'nullable|numeric',
            'delivery_time'        => 'nullable',
            'product_image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        //  dd($request );
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
            'quntity'                     => $request->quntity,
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
        $vendor = null; 
        $customer_id = Session::get('customer_id');
        $vendor_id   = Session::get('vendor_id');
        $supplier_id = Session::get('supplier_id');

        //    dd( $supplier_id );
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
            ->leftJoin('experience_years as ey', 'ey.id', '=', 's.years_in_business')
            

            ->select(
                's.*','c.name as cityname','r.name as regionname','sn.name as statename',
                'cd.days as credit_days_value','ey.experiance as experiance_year'
            )
            ->where('s.id', $id)
            ->first();
        if (!$supplier) {
            abort(404);
        }
       
      
       $materials = DB::table('supplier_products_data as sp')
                    ->leftJoin('material_categories as mc', 'mc.id', '=', 'sp.material_category_id')
                    ->leftJoin('material_product as mp', 'mp.id', '=', 'sp.material_product_id')
                    ->leftJoin('material_product_subtype as mps', 'mps.id', '=', 'sp.material_product_subtype_id')
                    ->leftJoin('brands as br', 'br.id', '=', 'sp.brand_id')
                    ->leftJoin('unit as u', 'u.id', '=', 'sp.unit_id')
                    ->where('sp.supp_id', $id)
                 
                    ->select([
                        'sp.image as p_image','sp.gst_percent as gst_percent',
                        'mc.id  as category_id',
                        'mp.id  as product_id',
                        'mps.id as spec_id',
                        'sp.quntity as spquntity',
                        'br.id  as brand_id',
                        'u.unitname as unitname', 'sp.price as price',

                        DB::raw('TRIM(mc.name) as category_name'),
                        DB::raw('TRIM(mp.product_name) as product_name'),
                        DB::raw('TRIM(mps.material_subproduct) as material_subproduct'),
                        DB::raw('TRIM(br.name) as brand_name'),
                    ])


                    ->distinct()
                    ->get();
   
                /**
                 * Grouping:
                 * Category → Product
                 */
                $grouped = $materials
                    ->groupBy('category_name')
                    ->map(function ($categoryItems) {
                        return $categoryItems->groupBy('product_name');
                    });
                $categories = $materials
                    ->pluck('category_name')
                    ->unique()
                    ->values();

        // dd( $grouped);
        return view('web.supplier_profile', compact('supplier','grouped', 'materials','layout','cust_data','vendor' ,'vendor_id','notifications','notificationCount'));
    }


    public function productenquiry()
    {
        $supplier_id = Session::get('supplier_id');

        $supplierName = DB::table('supplier_reg')
            ->where('id', $supplier_id)
            ->value('contact_person');

        $allEnquiries = DB::table('supplier_enquiries as se')
            ->join('supplier_reg as sr', 'se.supplier_id', '=', 'sr.id')
            ->join('supplier_enquiry_items as sei', 'sei.enquiry_id', '=', 'se.id')

            ->join('material_categories as mc', 'sei.category_id', '=', 'mc.id')
            ->where('se.supplier_id', $supplier_id)
            ->select(
                'se.*','sei.*',
                'sr.contact_person',
                'sr.shop_name',
                'sr.mobile',
                'sr.email',
                'mc.name as material_categories_name'
            )
            ->orderBy('se.created_at', 'DESC')
            ->get();
        // dd($allEnquiries);
        // ✅ NEW = status IS NULL
        $newEnquiries = $allEnquiries->whereNull('status');

        // ✅ QUOTED
        $quotedEnquiries = $allEnquiries->where('status', 'quoted');

        return view('web.productenquiry', compact(
            'supplierName',
            'allEnquiries',
            'newEnquiries',
            'quotedEnquiries'
        ));
    }

    public function acceptEnquiry(Request $request)
    {
        // dd($request);
        $supplier = DB::table('supplier_enquiries')
                    ->where('id', $request->enquiry_id)
                    ->where('supplier_id', $request->supplier_id)
                    ->update(['status' => 'accepted']);

        return response()->json([
            'status' => true,
            'message' => 'Enquiry accepted successfully'
        ]);
    }

    public function rejectEnquiry(Request $request)
    {
        $supplier = DB::table('supplier_enquiries')->where('supplier_id', $request->supplier_id)
            ->update(['status' => 'rejected']);

        return response()->json([
            'status' => true,
            'message' => 'Enquiry rejected'
        ]);
    }

   

    public function sendQuote(Request $request)
    {
        $request->validate([
            'enquiry_id'    => 'required|integer',
            'price'         => 'required|string',
            'delivery_time' => 'required|string',
            'notes'         => 'nullable|string',
            'quote_file'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $supplier_id = Session::get('supplier_id');

        if (!$supplier_id) {
            return back()->with('error', 'Unauthorized access');
        }

        // Upload quote file
        $quoteFilePath = null;
        if ($request->hasFile('quote_file')) {
            $quoteFilePath = $request->file('quote_file')
                ->store('supplier_quotes', 'public');
        }

        // Save quotation
        DB::table('supplier_quotes')->insert([
            'enquiry_id'    => $request->enquiry_id,
            'supplier_id'   => $supplier_id,
            'price'         => $request->price,
            'delivery_time' => $request->delivery_time,
            'notes'         => $request->notes,
            'quote_file'    => $quoteFilePath,
            'status'        => 'sent',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // OPTIONAL: update enquiry status
        DB::table('supplier_enquiries')
            ->where('id', $request->enquiry_id)
            ->update([
                'status' => 'quoted',
                'updated_at' => now()
            ]);

        return back()->with('success', 'Quotation sent successfully');
    }

    public function allsupplierenquiry(Request $request)
    {
        $notificationCount = 0;
        $notifications = collect();
        $cust_data = null;
        $vendor = null;

        $customer_id = Session::get('customer_id');
        $vendor_id   = Session::get('vendor_id');

        $layout = 'layouts.guest';

        // ✅ common search
        $search = $request->q;

        /* ================= CUSTOMER ================= */
        if ($customer_id) {

            $cust_data = DB::table('users')->where('id', $customer_id)->first();

            $notifications = DB::table('vendor_interests')->get();
            $notificationCount = $notifications->count();

            $enquiries = DB::table('supplier_enquiries as se')
                ->leftJoin('supplier_reg as s', 's.id', '=', 'se.supplier_id')
                ->where('se.user_id', 'c_'.$customer_id)
                ->when($search, function ($query) use ($search) {
                    $query->where(function($q) use ($search){
                        $q->where('s.shop_name', 'like', "%{$search}%")
                        ->orWhere('se.delivery_location', 'like', "%{$search}%")
                        ->orWhere('se.id', 'like', "%{$search}%");
                    });
                })
                ->select(
                    'se.id',
                    'se.created_at',
                    'se.delivery_location',
                    's.shop_name','s.mobile'
                )
                ->orderBy('se.id','desc')
                ->paginate(10); // ✅ pagination

            $layout = 'layouts.custapp';
        }

        /* ================= VENDOR ================= */
        elseif ($vendor_id) {

            $vendor = DB::table('vendor_reg')->where('id', $vendor_id)->first();

            $notifications = DB::table('customer_interests')->get();
            $notificationCount = $notifications->count();

            $enquiries = DB::table('supplier_enquiries as se')
                ->leftJoin('supplier_reg as s', 's.id', '=', 'se.supplier_id')
                ->where('se.user_id', 'v_'.$vendor_id)
                ->when($search, function ($query) use ($search) {
                    $query->where(function($q) use ($search){
                        $q->where('s.shop_name', 'like', "%{$search}%")
                        ->orWhere('se.delivery_location', 'like', "%{$search}%")
                        ->orWhere('se.id', 'like', "%{$search}%");
                    });
                })
                ->select(
                    'se.id',
                    'se.created_at',
                    'se.delivery_location',
                    's.shop_name','s.mobile'
                )
                ->orderBy('se.id','desc')
                ->paginate(10); // ✅ pagination
// dd( $enquiries);
            $layout = 'layouts.vendorapp';
        }

        else {
            abort(403);
        }

        return view('web.supplier_enquiry_index', compact(
            'enquiries',
            'layout',
            'vendor_id',
            'cust_data',
            'vendor',
            'notifications',
            'notificationCount'
        ));
    }

    public function supplierenquiryshow($id)
    {
        $notificationCount = 0;
        $notifications = collect();
        $vendor = null;
        $cust_data = null;

        $customer_id = Session::get('customer_id');
        $vendor_id   = Session::get('vendor_id');

        $layout = 'layouts.guest';

        /* ================= CUSTOMER ================= */
        if ($customer_id) {

            $cust_data = DB::table('users')->where('id', $customer_id)->first();

            $postIds = DB::table('posts')
                ->where('user_id', $customer_id)
                ->pluck('id');

            $notifications = DB::table('vendor_interests as vi')
                ->whereIn('vi.customer_id', $postIds)
                ->get();

            $notificationCount = $notifications->count();
            $layout = 'layouts.custapp';
        }
        /* ================= VENDOR ================= */
        elseif ($vendor_id) {

            $vendor = DB::table('vendor_reg')->where('id', $vendor_id)->first();

            $vendIds = DB::table('vendor_reg')
                ->where('id', $vendor_id)
                ->pluck('id');

            $notifications = DB::table('customer_interests as ci')
                ->join('users as u', 'u.id', '=', 'ci.customer_id')
                ->whereIn('ci.vendor_id', $vendIds)
                ->select('ci.*', 'u.*')
                ->get();

            $notificationCount = $notifications->count();
            $layout = 'layouts.vendorapp';
        }

        /* ================= ENQUIRY MASTER ================= */
        $enquiry = DB::table('supplier_enquiries as se')
            ->leftJoin('supplier_reg as s', 's.id', '=', 'se.supplier_id')
            ->select('se.*','s.shop_name','s.mobile','s.city_id','s.state_id')
            ->where('se.id', $id)
            ->first();

        if (!$enquiry) abort(404);

        /* ================= ENQUIRY ITEMS ================= */
        $items = DB::table('supplier_enquiry_items as ei')
            ->leftJoin('material_categories as mc', 'mc.id', '=', 'ei.category_id')
            ->leftJoin('material_product as mp', 'mp.id', '=', 'ei.product_id')
            ->leftJoin('material_product_subtype as ms', 'ms.id', '=', 'ei.spec_id')
            ->leftJoin('brands as b', 'b.id', '=', 'ei.brand_id')
            ->select(
                'mc.name as category',
                'mp.product_name as product',
                'ms.material_subproduct as spec',
                'b.name as brand',
                'ei.qty'
            )
            ->where('ei.enquiry_id', $id)
            ->get();

        /* ================= QUOTATIONS (NEW) ================= */
        /* ================= QUOTATIONS (from quotations table) ================= */
        $quotes = DB::table('quotations as q')
            ->leftJoin('supplier_reg as sr', 'sr.id', '=', 'q.supplier_id')
            ->leftJoin('supplier_enquiry_items as ei', 'ei.id', '=', 'q.item_id')
            ->leftJoin('material_categories as mc', 'mc.id', '=', 'ei.category_id')
            ->leftJoin('material_product as mp', 'mp.id', '=', 'ei.product_id')
            ->leftJoin('material_product_subtype as ms', 'ms.id', '=', 'ei.spec_id')
            ->leftJoin('brands as b', 'b.id', '=', 'ei.brand_id')
            ->select(
                'q.*',
                'sr.shop_name as supplier_name',
                'mc.name as category',
                'mp.product_name as product',
                'ms.material_subproduct as spec',
                'b.name as brand'
            )
            ->where('q.enquiry_id', $id)
            ->orderBy('q.id', 'desc')
            ->get();

        /* Summary (grand total etc.) */
        $quoteSummary = (clone DB::table('quotations'))
            ->where('enquiry_id', $id)
            ->selectRaw('COUNT(*) as rows_count, SUM(total) as grand_total')
            ->first();

        

        return view('web.supplier_enquiry_show', compact(
            'enquiry',
            'items',
            'quotes',
            'quoteSummary',
            'layout',
            'cust_data',
            'vendor',
            'notifications',
            'notificationCount'
        ));
    }

  
    public function quotationForm($enquiry_id)
    {
        // 1️⃣ Get enquiry (single row)
        $enquiry = DB::table('supplier_enquiries')
            ->where('id', $enquiry_id)
            ->first();

        abort_if(!$enquiry, 404);

        // 2️⃣ Detect user type from user_id
        $userType = explode('_', $enquiry->user_id)[0]; // c or v
        // dd($userType);
        $userId   = explode('_', $enquiry->user_id)[1]; // numeric id

        $user = null;

        // 3️⃣ Load correct user
        if ($userType === 'c') {
            // CUSTOMER
            $user = DB::table('users')
                ->where('id', $userId)
                ->first();
        } elseif ($userType === 'v') {
            // VENDOR
            $user = DB::table('vendor_reg')
                ->where('id', $userId)
                ->first();
        }


        $items =    DB::table('supplier_enquiry_items as ei')
            ->leftJoin('material_categories as mc', 'mc.id', '=', 'ei.category_id')
            ->leftJoin('material_product as mp', 'mp.id', '=', 'ei.product_id')
            ->leftJoin('material_product_subtype as ms', 'ms.id', '=', 'ei.spec_id')
            ->leftJoin('brands as b', 'b.id', '=', 'ei.brand_id')
            ->select(

                'mc.name as category',
                'mp.product_name as product',
                'ms.material_subproduct as spec',
                'b.name as brand',
                'ei.*'
            )
            ->where('ei.enquiry_id', $enquiry_id)
            ->get();

        return view('web.send-custquotation', compact('enquiry', 'user', 'items'));
    }


    public function sendQuotationtocust(Request $request)
    {
        $supp_id = session('supplier_id');
        // dd($request->all()); // enable once to verify

        $request->validate([
            'enquiry_id' => 'required',
            'items'      => 'required|array',
            'items.*.qty'   => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.gst'   => 'nullable|numeric|min:0',
        ]);

        $grandTotal = 0;

        foreach ($request->items as $item) {

            $qty   = $item['qty'];
            $price = $item['price'];
            $gst   = $item['gst'] ?? 0;

            $amount = $qty * $price;
            $gstAmt = ($amount * $gst) / 100;
            $total  = $amount + $gstAmt;

            $grandTotal += $total;

            // 🔹 Save each row
            DB::table('quotations')->insert([
                'enquiry_id'  => $request->enquiry_id,
                'supplier_id' => $supp_id,

                'item_id'     => $item['item_id'], // optional but recommended
                'rate'        => $price,
                'qty'         => $qty,
                'gst_percent' => $gst,
                'total'       => $total,

                'remarks'     => $request->remarks,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }


        return redirect()
            ->route('supplier.orders')
            ->with('success', 'Quotation sent successfully');
    }

    public function quotesorders(){
        $supp_id = session('supplier_id');
        $supplierName = DB::table('supplier_reg')
            ->where('id', $supp_id)
            ->value('contact_person');
         // 🔹 Fetch quotations for this supplier
        $quotationItems = DB::table('quotations')
                        ->where('supplier_id', $supp_id)
                        ->orderBy('created_at', 'desc')
                        ->get();
                        // No data safety
        if ($quotationItems->isEmpty()) {
            return view('web.quotes&order')->with([
                'quotationItems' => collect(),
                'quotationStatus' => null
            ]);
        }
          // 🔹 Status is same for all items of same enquiry
        $quotationStatus = $quotationItems->first()->status;
        return view('web.quotes&order', compact('quotationItems', 'quotationStatus','supplierName'));
    }

    public function supplierandorder(){
        $supp_id = session('supplier_id');
        $supplierName = DB::table('supplier_reg')
            ->where('id', $supp_id)
            ->value('contact_person');
         // 🔹 Fetch quotations for this supplier
        $quotationItems = DB::table('quotations')
                        ->where('supplier_id', $supp_id)
                        ->orderBy('created_at', 'desc')
                        ->get();
                        // No data safety
        if ($quotationItems->isEmpty()) {
            return view('web.quotes&order')->with([
                'quotationItems' => collect(),
                'quotationStatus' => null
            ]);
        }
          // 🔹 Status is same for all items of same enquiry
        $quotationStatus = $quotationItems->first()->status;
        //  dd($quotationItems);
        return view('web.quotes&order', compact('quotationItems', 'quotationStatus','supplierName'));
    }

    
    public function quotationAccept($id)
    {
        $customer_id = Session::get('customer_id');
        if(!$customer_id){
            return redirect()->back()->with('error', 'Login required');
        }

        // quotation fetch + security: only customer who owns enquiry can accept
        $q = DB::table('quotations as qt')
            ->join('supplier_enquiries as se', 'se.id', '=', 'qt.enquiry_id')
            ->where('qt.id', $id)
            ->where('se.user_id', 'c_'.$customer_id)
            ->select('qt.*','se.id as enquiry_id')
            ->first();

        if(!$q) abort(403);

        DB::table('quotations')
            ->where('id', $id)
            ->update([
                'status' => 'accepted',
                'customer_response_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        // ✅ OPTIONAL: if you want "only one accepted" then uncomment below:
        // DB::table('quotations')
        //     ->where('enquiry_id', $q->enquiry_id)
        //     ->where('supplier_id', '!=', $q->supplier_id)
        //     ->update([
        //         'status' => 'rejected',
        //         'customer_response_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ]);

        return redirect()->back()->with('success', 'Quotation accepted. Order placed successfully!');
    }

    public function quotationReject($id)
    {
        $customer_id = Session::get('customer_id');
        if(!$customer_id){
            return redirect()->back()->with('error', 'Login required');
        }

        $q = DB::table('quotations as qt')
            ->join('supplier_enquiries as se', 'se.id', '=', 'qt.enquiry_id')
            ->where('qt.id', $id)
            ->where('se.user_id', 'c_'.$customer_id)
            ->select('qt.*')
            ->first();

        if(!$q) abort(403);

        DB::table('quotations')
            ->where('id', $id)
            ->update([
                'status' => 'rejected',
                'customer_response_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        return redirect()->back()->with('success', 'Quotation rejected.');
    }

    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'quntity' => 'required|integer|min:0'
        ]);

        DB::table('supplier_products_data')
            ->where('id', $id)
            ->update([
                'quntity' => $request->quntity,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Quantity updated successfully');
    }

}
