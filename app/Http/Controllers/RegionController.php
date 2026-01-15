<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class RegionController extends Controller
{
    public function index()
    {
        $states  = DB::table('state')->get();
        $regions = DB::table('region')
            ->join('state','state.id','=','region.state_id')
            ->select('region.*','state.name as state_name')
            ->get();

        return view('web.master.regions', compact('states','regions'));
    }

    public function store(Request $request)
    {
        DB::table('region')->insert([
            'name' => $request->name,
            'state_id' => $request->state_id,
            'created_at' => now()
        ]);

        return back()->with('success','Region added');
    }

    public function byState($stateId)
    {
        return DB::table('region')
            ->where('state_id',$stateId)
            ->orderBy('name')
            ->get();
    }
}
