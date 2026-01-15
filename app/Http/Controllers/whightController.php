<?php

namespace App\Http\Controllers;

use App\Models\Whight;
use Illuminate\Http\Request;

class whightController extends Controller
{
    public function index()
    {
        $Whights = Whight::orderBy('id','desc')->get();
        // dd( $Whights);
        return view('web.master.Whight', compact('Whights'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Whight::create([
            'name' => $request->name
        ]);

        return back()->with('success','Whight added successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Whight::where('id',$id)->update([
            'name' => $request->name
        ]);

        return back()->with('success','Whight updated successfully');
    }

    public function destroy($id)
    {
        Whight::where('id',$id)->delete();
        return back()->with('success','Whight deleted successfully');
    }
}
