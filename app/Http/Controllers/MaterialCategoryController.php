<?php

namespace App\Http\Controllers;

use App\Models\MaterialCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MaterialCategoryController extends Controller
{
   
    public function index(Request $request)
    {
        $categories = MaterialCategory::orderBy('sort_order')->paginate(10);

        if ($request->ajax()) {
            return view('web.master.material-categories-table', compact('categories'))->render();
        }

        return view('web.master.materialcategorylist', compact('categories'));
    }


    public function create()
    {
         $nextSortOrder = (MaterialCategory::max('sort_order') ?? 0) + 1;
        return view('web.master.create',compact('nextSortOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer'
        ]);

        MaterialCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status ?? 1,
            'sort_order' => $request->sort_order ?? 0
        ]);

        return redirect()->route('material-categories.index')
            ->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $category = MaterialCategory::findOrFail($id);
        return view('web.master.create', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = MaterialCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer'
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
            'sort_order' => $request->sort_order
        ]);

        return redirect()->route('material-categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = MaterialCategory::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category already deleted'
            ], 200);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully'
        ]);
    }


    public function updateStatus($id)
    {
        $category = MaterialCategory::findOrFail($id);
        $category->status = !$category->status;
        $category->save();

        return response()->json(['success' => true]);
    }
}
