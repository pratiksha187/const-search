<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::orderBy('id','desc')->get();
        return view('web.master.grade', compact('grades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grade_name' => 'required|unique:grade_master,grade_name'
        ]);

        Grade::create([
            'grade_name' => $request->grade_name
        ]);

        return back()->with('success','Grade added successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'grade_name' => 'required|unique:grade_master,grade_name,'.$id
        ]);

        Grade::where('id',$id)->update([
            'grade_name' => $request->grade_name
        ]);

        return back()->with('success','Grade updated successfully');
    }

    public function destroy($id)
    {
        Grade::where('id',$id)->delete();
        return back()->with('success','Grade deleted successfully');
    }
}
