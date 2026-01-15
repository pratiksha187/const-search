<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    // Fetch regions by state
    public function getRegions($stateId)
    {
        return DB::table('region')
            ->where('state_id', $stateId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    // Fetch cities by region
    public function getCities($regionId)
    {
        // dd($regionId);
        return DB::table('city')
            ->where('region_id', $regionId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }


    public function addmaster(){
        return view('web.master.addmaster');
    }
}
