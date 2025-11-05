# Perbaikan Error "Target class [role] does not exist"

## Masalah yang Ditemukan

1. **Middleware tidak terdaftar**: Middleware `role` tidak terdaftar di `bootstrap/app.php`
2. **Inkonsistensi sistem role**: Aplikasi menggunakan dua sistem role yang berbeda:
   - Kolom `role` sederhana di tabel `users`
   - Spatie Laravel Permission (sistem role & permission yang kompleks)

## Perbaikan yang Dilakukan

### 1. Registrasi Middleware (bootstrap/app.php)
```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
```

### 2. Update RoleMiddleware (app/Http/Middleware/RoleMiddleware.php)
Mengubah middleware untuk menggunakan Spatie Permission secara konsisten:
```php
public function handle(Request $request, Closure $next, string $roles): Response
{
    if (!$request->user()) {
        abort(401, 'Unauthenticated.');
    }

    $allowedRoles = explode('|', $roles);

    // Menggunakan hasAnyRole() dari Spatie Permission
    if (!$request->user()->hasAnyRole($allowedRoles)) {
        abort(403, 'Unauthorized. Required role: ' . implode(' or ', $allowedRoles));
    }

    return $next($request);
}
```

### 3. Menjalankan Seeder
```bash
php artisan db:seed --class=RolePermissionSeeder
```

## Sistem Role yang Digunakan

Aplikasi sekarang menggunakan **Spatie Laravel Permission** secara penuh dengan:

### Roles:
- **admin**: Akses penuh ke semua fitur
- **manager**: Akses ke kategori, supplier, produk, dan stok
- **staff**: Akses terbatas ke dashboard, view produk, dan manajemen stok

### Permissions:
- `dashboard.view`
- `category.*` (view, create, update, delete)
- `supplier.*` (view, create, update, delete)
- `product.*` (view, create, update, delete)
- `stock.*` (view, in, out)
- `user.manage` (admin only)

## Cara Menggunakan

### Mengecek Role User:
```php
$user->hasRole('admin');
$user->hasAnyRole(['admin', 'manager']);
```

### Mengecek Permission:
```php
$user->can('category.create');
$user->hasPermissionTo('product.update');
```

### Di Blade Template:
```blade
@role('admin')
    <!-- Content for admin only -->
@endrole

@hasanyrole('admin|manager')
    <!-- Content for admin or manager -->
@endhasanyrole

@can('category.create')
    <!-- Content for users with category.create permission -->
@endcan
```

## Status
✅ Error "Target class [role] does not exist" - FIXED
✅ Middleware terdaftar dengan benar
✅ Sistem role konsisten menggunakan Spatie Permission
✅ Semua route dapat diakses sesuai role