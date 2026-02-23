<?php

namespace App\Http\Controllers;

use App\Models\ProfileType;
use App\Models\MaterialProductSubtype;
use Illuminate\Http\Request;

class ProfileTypeController extends Controller
{
   
    public function index(Request $request)
    {
        $search = $request->search;

        $profiletypes = ProfileType::with('subcategory')
            ->when($search, function ($q) use ($search) {
                $q->where('type', 'like', "%{$search}%")
                ->orWhereHas('subcategory', function ($s) use ($search) {
                    $s->where('material_subproduct', 'like', "%{$search}%");
                });
            })
            ->orderBy('id','desc')
            ->paginate(20);

        return view('web.master.profiletype-list', compact('profiletypes'));
    }

    public function create()
    {
        $subcategories = MaterialProductSubtype::orderBy('material_product_id','asc')
                            ->orderBy('id','asc')
                            ->get();

        return view(
            'web.master.profiletype-form',
            compact('subcategories')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'sub_categories_id' => 'required|exists:material_product_subtype,id'
        ]);

        ProfileType::create($request->all());

        return redirect()
            ->route('profiletypes.index')
            ->with('success','Profile Type added successfully');
    }

    public function edit($id)
    {
        $profiletype = ProfileType::findOrFail($id);

        $subcategories = MaterialProductSubtype::orderBy('material_product_id','asc')
                            ->orderBy('id','asc')
                            ->get();

        return view(
            'web.master.profiletype-form',
            compact('profiletype','subcategories')
        );
    }

    public function update(Request $request, $id)
    {
        $profiletype = ProfileType::findOrFail($id);

        $request->validate([
            'type' => 'required|string|max:255',
            'sub_categories_id' => 'required|exists:material_product_subtype,id'
        ]);

        $profiletype->update($request->all());

        return redirect()
            ->route('profiletypes.index')
            ->with('success','Profile Type updated successfully');
    }

    public function destroy($id)
    {
        $profiletype = ProfileType::find($id);

        if(!$profiletype){
            return response()->json(['success'=>false]);
        }

        $profiletype->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Profile Type deleted successfully'
        ]);
    }
}
