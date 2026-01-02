<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\MaterialProduct;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with('product')
                    ->orderBy('id','desc')
                    ->paginate(15);

        return view('web.master.brand-list', compact('brands'));
    }

    public function create()
    {
        // IMPORTANT: order by material_id ASC
        $products = MaterialProduct::orderBy('material_id','asc')->get();

        return view('web.master.brand-form', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'material_product_id' => 'required|exists:material_product,id'
        ]);

        Brand::create($request->all());

        return redirect()
            ->route('brands.index')
            ->with('success','Brand added successfully');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        $products = MaterialProduct::orderBy('material_id','asc')->get();

        return view('web.master.brand-form', compact('brand','products'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'material_product_id' => 'required|exists:material_product,id'
        ]);

        $brand->update($request->all());

        return redirect()
            ->route('brands.index')
            ->with('success','Brand updated successfully');
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);

        if(!$brand){
            return response()->json(['success'=>false]);
        }

        $brand->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Brand deleted successfully'
        ]);
    }
}
