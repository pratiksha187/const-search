<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class StateController extends Controller
{
    public function index()
    {
        $states = DB::table('state')->orderBy('name')->get();
        return view('web.master.states', compact('states'));
    }

    public function store(Request $request)
    {
        DB::table('state')->insert([
            'name' => $request->name,
            'created_at' => now()
        ]);

        return back()->with('success','State added');
    }
}
