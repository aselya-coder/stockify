<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        // Middleware untuk membatasi akses berdasarkan permission
        $this->middleware('permission:view-users')->only('index', 'show');
        $this->middleware('permission:create-users')->only('create', 'store');
        $this->middleware('permission:edit-users')->only('edit', 'update');
        $this->middleware('permission:delete-users')->only('destroy');
    }

    /**
     * Menampilkan daftar pengguna.
     */
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk menambah pengguna baru.
     * Admin tidak bisa membuat admin lain melalui form ini.
     */
    public function create()
    {
        // Hanya tampilkan role selain 'admin' sebagai pilihan
        $roles = Role::where('name', '!=', 'admin')->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Menyimpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name', // Validasi untuk satu role
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign satu role ke pengguna baru
        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit pengguna.
     */
    public function edit(User $user)
    {
        // Hanya tampilkan role selain 'admin' sebagai pilihan
        $roles = Role::where('name', '!=', 'admin')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Memperbarui data pengguna di database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // PERBAIKAN: Gunakan syncRoles untuk memperbarui role.
        // Meskipun hanya satu role yang dipilih, syncRoles lebih aman untuk menghapus role lama.
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna dari database.
     * Mencegah penghapusan pengguna dengan role 'admin'.
     */
    public function destroy(User $user)
    {
        // Cek apakah user yang akan dihapus memiliki role 'admin'
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus pengguna dengan role Admin.');
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}