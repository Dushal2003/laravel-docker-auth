<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            // quick KPIs for the tiles we built earlier
            'totalUsers'  => User::count(),
            'newUsers'    => User::whereDate('created_at', today())->count(),
            'admins'      => User::where('user_type', 'admin')->count(),
        ]);
    }
}
