<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return match (Auth::user()->role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'kasir'     => redirect()->route('kasir.dashboard'),
            default     => redirect()->route('pelanggan.dashboard'),
        };
    }

    public function admin()     { return view('dashboard.admin'); }
    public function kasir()     { return view('dashboard.kasir'); }
    public function pelanggan() { return view('dashboard.pelanggan'); }
}
