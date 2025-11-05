<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        // Render view dashboard untuk role manager
        // Pastikan resources/views/dashboard/manajer.blade.php tersedia
        return view('dashboard.manajer');
    }
}
