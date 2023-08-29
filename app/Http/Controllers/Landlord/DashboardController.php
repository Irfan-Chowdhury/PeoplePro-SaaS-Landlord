<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('landlord.super-admin.pages.dashboard.index');
    }
}
