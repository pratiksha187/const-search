<?php

namespace App\Http\Controllers;

use App\Models\MaterialProductSubtype;
use App\Models\MaterialProduct;
use Illuminate\Http\Request;

class MaterialProductSubtypeController extends Controller
{
    public function index()
    {
        $subtypes = MaterialProductSubtype::with('product')
                    ->orderBy('id','desc')
                    ->paginate(15);

        return view('web.master.material-product-subtype-list', compact('subtypes'));
    }

    public function create()
    {
        $products = MaterialProduct::orderBy('product_name')->get();
        return view('web.master.material-product-subtype-form', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_product_id' => 'required|exists:material_product,id',
            'material_subproduct' => 'required|string|max:255'
        ]);

        MaterialProductSubtype::create($request->all());

        return redirect()
            ->route('material-product-subtypes.index')
            ->with('success','Sub Product added successfully');
    }

    public function edit($id)
    {
        $subtype  = MaterialProductSubtype::findOrFail($id);
        $products = MaterialProduct::orderBy('product_name')->get();

        return view(
            'web.master.material-product-subtype-form',
            compact('subtype','products')
        );
    }

    public function update(Request $request, $id)
    {
        $subtype = MaterialProductSubtype::findOrFail($id);

        $request->validate([
            'material_product_id' => 'required|exists:material_product,id',
            'material_subproduct' => 'required|string|max:255'
        ]);

        $subtype->update($request->all());

        return redirect()
            ->route('material-product-subtypes.index')
            ->with('success','Sub Product updated successfully');
    }

    public function destroy($id)
    {
        $subtype = MaterialProductSubtype::find($id);

        if(!$subtype){
            return response()->json(['success'=>false]);
        }

        $subtype->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Sub Product deleted successfully'
        ]);
    }
}
