<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::orderBy('id','desc')->get();
        return view('web.master.unit', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unitname' => 'required|unique:unit,unitname'
        ]);

        Unit::create([
            'unitname' => $request->unitname
        ]);

        return back()->with('success','Unit added successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'unitname' => 'required|unique:unit,unitname,'.$id
        ]);

        Unit::where('id',$id)->update([
            'unitname' => $request->unitname
        ]);

        return back()->with('success','Unit updated successfully');
    }

    public function destroy($id)
    {
        Unit::where('id',$id)->delete();
        return back()->with('success','Unit deleted successfully');
    }
}
