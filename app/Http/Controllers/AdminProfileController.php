<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    /**
     * Display the admin's profile page.
     */
    public function show()
    {
        $admin = Auth::user();
        return view('admin_profile', compact('admin'));
    }
}
