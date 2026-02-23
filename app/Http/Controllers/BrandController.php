<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\MaterialProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->search;

        $brands = Brand::with('product')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhereHas('product', function ($p) use ($search) {
                    $p->where('product_name', 'like', "%{$search}%");
                });
            })
            ->orderBy('id','desc')
            ->paginate(15);

        return view('web.master.brand-list', compact('brands'));
    }


    public function create()
    {
        $products = MaterialProduct::orderBy('material_id', 'asc')->get();
        return view('web.master.brand-form', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'material_product_id' => 'required|exists:material_product,id',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/brands', $filename);
            $data['logo'] = $filename;
        }

        Brand::create($data);

        return redirect()
            ->route('brands.index')
            ->with('success','Brand added successfully');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        $products = MaterialProduct::orderBy('material_id', 'asc')->get();
        return view('web.master.brand-form', compact('brand','products'));
    }

   
    public function update(Request $request, $id)
{
    $brand = Brand::findOrFail($id);

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'material_product_id' => 'required|exists:material_product,id',
        'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // Only replace logo if a new file is uploaded
    if ($request->hasFile('logo')) {

        // Delete old logo if exists
        if ($brand->logo && Storage::exists('public/brands/'.$brand->logo)) {
            Storage::delete('public/brands/'.$brand->logo);
        }

        $file = $request->file('logo');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->storeAs('public/brands', $filename);

        $data['logo'] = $filename; // VERY IMPORTANT
    }

    $brand->update($data);

    return redirect()->route('brands.index')->with('success','Brand updated successfully');
}


    public function destroy($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['success'=>false]);
        }

        if ($brand->logo && Storage::exists('public/brands/'.$brand->logo)) {
            Storage::delete('public/brands/'.$brand->logo);
        }

        $brand->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Brand deleted successfully'
        ]);
    }
}
