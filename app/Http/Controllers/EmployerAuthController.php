<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class EmployerAuthController extends Controller
{
    public function showLogin()
    {
        return view('web.employers.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $employer = DB::table('employers')
            ->where('email', $request->email)
            ->first();

        if (!$employer) {
            return back()->with('error', 'Invalid email or password.')->withInput();
        }

        if ((int)($employer->is_active ?? 1) !== 1) {
            return back()->with('error', 'Your account is inactive. Please contact admin.');
        }

        if (!Hash::check($request->password, $employer->password)) {
            return back()->with('error', 'Invalid email or password.')->withInput();
        }

        // ✅ Save in session
        Session::put('employer_id', $employer->id);
        Session::put('employer_name', $employer->name);
        Session::put('employer_email', $employer->email);

        return redirect()->route('employers.dashboard');
    }

    public function logout(Request $request)
    {
        Session::forget(['employer_id', 'employer_name', 'employer_email']);
        return redirect()->route('employer.login')->with('success', 'Logged out successfully.');
    }
}
