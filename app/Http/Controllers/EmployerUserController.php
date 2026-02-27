<?php

namespace App\Http\Controllers;

use App\Models\EmployerUser;
use Illuminate\Http\Request;
use App\Http\Middleware\SwitchEmployerDatabase;

class EmployerUserController extends Controller
{
  
    public function user_roles()
    {
        $users = EmployerUser::latest()->get();
        // dd($users);
        return view('web.employers.user_roles', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employer_users,email',
            'role' => 'required',
            'user_type' => 'required'
        ]);

        EmployerUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'user_type' => $request->user_type,
            'is_paid' => $request->user_type == 'action' ? 1 : 0
        ]);

        return back()->with('success', 'User Added Successfully');
    }

    public function update(Request $request, $id)
    {
        $user = EmployerUser::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'role' => $request->role,
            'user_type' => $request->user_type,
            'is_paid' => $request->user_type == 'action' ? 1 : 0
        ]);

        return back()->with('success', 'User Updated');
    }

    public function destroy($id)
    {
        EmployerUser::findOrFail($id)->delete();
        return back()->with('success', 'User Deleted');
    }
}