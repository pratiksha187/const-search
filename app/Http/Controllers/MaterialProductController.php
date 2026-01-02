<?php

namespace App\Http\Controllers;

use App\Models\MaterialProduct;
use App\Models\MaterialCategory;
use Illuminate\Http\Request;

class MaterialProductController extends Controller
{
    public function index()
    {
        $products = MaterialProduct::with('category')
                    ->orderBy('id','desc')
                    ->paginate(10);

        return view('web.master.material-product-list', compact('products'));
    }

    public function create()
    {
        $categories = MaterialCategory::orderBy('name')->get();
        // dd($categories);
        return view('web.master.material-product-form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:material_categories,id',
            'product_name' => 'required|string|max:255'
        ]);

        MaterialProduct::create($request->all());

        return redirect()
            ->route('material-products.index')
            ->with('success','Product added successfully');
    }

    public function edit($id)
    {
        $product = MaterialProduct::findOrFail($id);
        $categories = MaterialCategory::orderBy('name')->get();

        return view('web.master.material-product-form', compact('product','categories'));
    }

    public function update(Request $request, $id)
    {
        $product = MaterialProduct::findOrFail($id);

        $request->validate([
            'material_id' => 'required|exists:material_categories,id',
            'product_name' => 'required|string|max:255'
        ]);

        $product->update($request->all());

        return redirect()
            ->route('material-products.index')
            ->with('success','Product updated successfully');
    }

    public function destroy($id)
    {
        $product = MaterialProduct::find($id);

        if(!$product){
            return response()->json(['success'=>false]);
        }

        $product->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Product deleted successfully'
        ]);
    }
}
