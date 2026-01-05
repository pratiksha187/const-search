<?php

namespace App\Http\Controllers;

use App\Models\ThicknessSize;
use Illuminate\Http\Request;

class ThicknessSizeController extends Controller
{
    public function index()
    {
        $sizes = ThicknessSize::orderBy('id','desc')->get();
        return view('web.master.thickness_size', compact('sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'thickness_size' => 'required|unique:thickness_size,thickness_size'
        ]);

        ThicknessSize::create([
            'thickness_size' => $request->thickness_size
        ]);

        return back()->with('success','Thickness size added successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'thickness_size' => 'required|unique:thickness_size,thickness_size,'.$id
        ]);

        ThicknessSize::where('id',$id)->update([
            'thickness_size' => $request->thickness_size
        ]);

        return back()->with('success','Thickness size updated successfully');
    }

    public function destroy($id)
    {
        ThicknessSize::where('id',$id)->delete();
        return back()->with('success','Thickness size deleted successfully');
    }
}
