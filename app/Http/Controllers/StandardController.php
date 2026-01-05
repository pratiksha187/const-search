<?php

namespace App\Http\Controllers;

use App\Models\Standard;
use Illuminate\Http\Request;

class StandardController extends Controller
{
    public function index()
    {
        $standards = Standard::orderBy('id','desc')->get();
        return view('web.master.standard', compact('standards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'standard_name' => 'required|unique:standard_master,standard_name'
        ]);

        Standard::create([
            'standard_name' => $request->standard_name
        ]);

        return back()->with('success','Standard added successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'standard_name' => 'required|unique:standard_master,standard_name,'.$id
        ]);

        Standard::where('id',$id)->update([
            'standard_name' => $request->standard_name
        ]);

        return back()->with('success','Standard updated successfully');
    }

    public function destroy($id)
    {
        Standard::where('id',$id)->delete();
        return back()->with('success','Standard deleted successfully');
    }
}
