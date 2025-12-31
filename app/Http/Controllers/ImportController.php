<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    public function test(){
        return view('web.test');
    }
   public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    $data = Excel::toArray([], $request->file('file'));
    $rows = $data[0];

    // remove header row
    unset($rows[0]);

    foreach ($rows as $row) {

        // skip empty title rows
        if (empty($row[1])) {
            continue;
        }

        DB::table('posts')->insert([
            'title'        => $row[1],   // ✅ Project Title
            'state'        => $row[4],   // ✅ State
            'region'       => $row[5],   // ✅ Region
            'city'         => $row[6],   // ✅ City
            'contact_name' => $row[8],   // ✅ Contact Name
            'mobile'       => $row[9],   // ✅ Mobile
            'email'        => $row[10],  // ✅ Email
            'description'  => $row[12],  // ✅ Project Description
             'area'  => $row[13],
            'created_at'   => now(),
        ]);
    }

    return back()->with('success', 'Excel imported correctly');
}
}
