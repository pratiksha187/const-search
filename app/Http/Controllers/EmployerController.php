<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Services\TenantSqlProvisioningService;
use Illuminate\Support\Str;

class EmployerController extends Controller
{

    public function index()
    {
        $employers = DB::table('employers')
            ->orderByDesc('id')
            ->get();

        return view('web.employers.index', compact('employers'));
    }
    public function create()
    {
        return view('web.employers.create');
    }

 
    
    public function store(Request $request, TenantSqlProvisioningService $tenantSql)
    {
        $validated = $request->validate([
            // employer
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:employers,email',
            'mobile'   => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',

            // company
            'company_name'    => 'required|string|max:255',
            'company_email'   => 'nullable|email|max:255',
            'company_phone'   => 'nullable|string|max:20',
            'gst_number'      => 'nullable|string|max:30',
            'pan_number'      => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:1000',
            'state'           => 'nullable|string|max:100',
            'city'            => 'nullable|string|max:100',
            'pincode'         => 'nullable|string|max:10',
            'website'         => 'nullable|string|max:255',

            'is_active'       => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            // ✅ create tenant database name
            $slug = Str::slug($validated['company_name'], '_');
            $dbName = 'ck_erp_' . $slug . '_' . time();  // ex: ck_erp_company_170...

            // ✅ save employer in MASTER db
            $plainPassword = $validated['password']; // keep before hashing
            $validated['password'] = Hash::make($validated['password']);
            $validated['is_active'] = $request->boolean('is_active', true);
            $validated['db_name'] = $dbName;

            $employer = Employer::create($validated);

            $tenantSql->provision($dbName);

            // Switch DB
            $tenantSql->switchTenantDb($dbName);

            // logger(DB::connection('tenant')->getDatabaseName());
            DB::connection('tenant')->table('users')->insert([
                'name'       => $validated['name'],
                'email'      => $validated['email'],
                'mobile'     => $validated['mobile'] ?? null,
                'password'   => Hash::make($plainPassword),
                'role'       => 'employer_admin',
                'active'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('admin.employers.create')
                ->with('success', 'Employer added successfully + Tenant DB created ✅');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
public function switchTenantDb(string $dbName): void
{
    // Set DB name dynamically
    Config::set('database.connections.tenant.database', $dbName);

    // Forget old connection
    DB::purge('tenant');

    // Reconnect with new DB
    DB::reconnect('tenant');
}
 

    public function toggleStatus($id)
    {
        $emp = DB::table('employers')->where('id', $id)->first();
        if (!$emp) return back()->with('error', 'Employer not found.');

        DB::table('employers')->where('id', $id)->update([
            'is_active' => $emp->is_active ? 0 : 1,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Status updated.');
    }

    public function destroy($id)
    {
        DB::table('employers')->where('id', $id)->delete();
        return back()->with('success', 'Employer deleted.');
    }
}
