<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VendorsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $vendors = DB::table('vendor_reg as v')
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
                'v.*',
                'wt.work_type as work_types',
                'r.name as regionname',
                's.name as statename',
                'c.name as cityname'
            )
            ->orderBy('v.created_at', 'desc')
            ->get();

        return $vendors->map(function ($vendor) {
            return [
                'ID'                => $vendor->id,
                'Vendor Name'       => $vendor->name,
                'Company Name'      => $vendor->business_name,
                'Work Type'         => $vendor->work_types,
                'Mobile'            => $vendor->mobile,
                'Status'            => $vendor->status,
                'Profile Percent' => \App\Helpers\ProfileCompletionHelper::vendor($vendor) . '%',
                'Region'            => $vendor->regionname,
                'State'             => $vendor->statename,
                'City'              => $vendor->cityname,
                'Created Date'      => $vendor->created_at,
            ];
        });
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
            'Profile Percent',
            'Region',
            'State',
            'City',
            'Created Date'
        ];
    }
}