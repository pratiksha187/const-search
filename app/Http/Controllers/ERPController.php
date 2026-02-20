<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ERPController extends Controller
{
    public function erp(){
        return view('web.erp');
    }

    public function erpproject(){
        return view('web.employers.project');

    }

    public function boq_rfq_bids(){
        return view('web.employers.boq_rfq_bids');
    }

    public function po_grm_invoice(){
        return view('web.employers.po_grn_invoice');
    }

    public function vendor_network(){
        return view('web.employers.vendor_network');
    }

    public function user_roles(){
        return view('web.employers.user_roles');
    }
}
