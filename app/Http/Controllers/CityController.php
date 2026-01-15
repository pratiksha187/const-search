<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class CityController extends Controller
{
    public function index()
    {
        $states = DB::table('state')->get();
        $cities = DB::table('city')
            ->join('region','region.id','=','city.region_id')
            ->join('state','state.id','=','region.state_id')
            ->select(
                'city.*',
                'region.name as region_name',
                'state.name as state_name'
            )
            ->get();

        return view('web.master.cities', compact('states','cities'));
    }

    public function store(Request $request)
    {
        DB::table('city')->insert([
            'name' => $request->name,
            'region_id' => $request->region_id,
            'created_at' => now()
        ]);

        return back()->with('success','City added');
    }

    public function byRegion($regionId)
    {
        return DB::table('city')
            ->where('region_id',$regionId)
            ->orderBy('name')
            ->get();
    }
}
