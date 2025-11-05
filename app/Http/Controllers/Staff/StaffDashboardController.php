<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffDashboardController extends Controller
{
    public function index()
    {
        // Render view dashboard untuk role staff
        // Pastikan resources/views/dashboard/staff.blade.php tersedia
        return view('dashboard.staff');
    }
}
