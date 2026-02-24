<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VendorsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('vendor_reg as v')
            ->leftJoin('work_types as wt', 'wt.id', '=', 'v.work_type_id')
            ->leftJoin('work_subtypes as wst', 'wst.id', '=', 'v.work_subtype_id')
            ->leftJoin('team_size as ts', 'ts.id', '=', 'v.team_size')
            ->leftJoin('experience_years as ey', 'ey.id', '=', 'v.experience_years')
            ->leftJoin('state as s', 's.id', '=', 'v.state')
            ->leftJoin('entity_type as et', 'et.id', '=', 'v.entity_type')
            ->leftJoin('account_type as at', 'at.id', '=', 'v.account_type')
            ->leftJoin('region as r', 'r.id', '=', 'v.region')
            ->leftJoin('city as c', 'c.id', '=', 'v.city')
            ->select(
                'v.id',
                'v.name',
                'v.business_name',
                'wt.work_type as work_types', // moved here (4th)
                'v.mobile',
                'v.status',
                'r.name as regionname',
                's.name as statename',
                'c.name as cityname',
                'v.created_at'
            )
            ->orderBy('v.created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Vendor Name',
            'Company Name',
            'Work Type',
            'Mobile',
            'Status',
            'Region',
            'State',
            'City',
            'Created Date'
        ];
    }
}