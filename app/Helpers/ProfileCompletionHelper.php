<?php

namespace App\Helpers;

class ProfileCompletionHelper
{
    public static function vendor($vendor)
    {
        if (!$vendor) return 0;

        $sections = [

            // BASIC INFO (20%)
            [
                'weight' => 20,
                'fields' => [
                    $vendor->name,
                    $vendor->mobile,
                    $vendor->email,
                    $vendor->business_name
                ]
            ],

            // BUSINESS DETAILS (15%)
            [
                'weight' => 20,
                'fields' => [
                    $vendor->work_type_id
                ]
            ],

            // PROFILE COMPLETION (25%)
            [
                'weight' => 20,
                'fields' => [
                    $vendor->experience_years,
                    $vendor->team_size,
                    $vendor->state,
                    $vendor->region,
                    $vendor->city,
                    $vendor->min_project_value,
                    $vendor->company_name,
                    $vendor->entity_type,
                    $vendor->registered_address,
                    $vendor->contact_person_designation
                ]
            ],

            // REQUIRED DOCUMENTS (30%)
            [
                'weight' => 30,
                'fields' => [
                    $vendor->requerd_documnet_approve
                    // $vendor->gst_certificate_file,
                    // $vendor->aadhaar_card_file,
                    // $vendor->certificate_of_incorporation_file
                ]
            ],

            // BANK DETAILS (10%)
            [
                'weight' => 10,
                'fields' => [
                    $vendor->bank_name,
                    $vendor->account_number,
                    $vendor->ifsc_code,
                    $vendor->account_type
                ]
            ],
        ];

        $percent = 0;

        foreach ($sections as $section) {

            $completed = true;

            foreach ($section['fields'] as $field) {
                if (empty($field)) {
                    $completed = false;
                    break;
                }
            }

            if ($completed) {
                $percent += $section['weight'];
            }
        }

        return min(100, $percent);
    }


}
