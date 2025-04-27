<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Admin: List all users
    public function index()
    {
        $users = User::all();
        return view('admin_users', compact('users'));
    }

    // Admin: Delete a user (except self or other admins)
    public function destroy(User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.users.index')->with('error', 'Cannot delete admin users.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}
