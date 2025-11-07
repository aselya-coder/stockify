<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-app-settings');
    }

    public function index()
    {
        // Contoh: ambil setting dari file config atau database
        $settings = [
            'app_name' => config('app.name'),
            'app_logo' => null, // Ganti dengan path logo jika ada
        ];
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Logika untuk menyimpan pengaturan
        // Contoh: update .env file atau simpan ke database
        // Untuk sekarang, kita hanya redirect dengan pesan sukses
        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diperbarui!');
    }
}