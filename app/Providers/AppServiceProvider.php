<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Fortify is optional and may not be present in some environments, so we avoid a direct import here.

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Pastikan alias middleware 'role' selalu terdaftar
        app('router')->aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);

        // Tautkan view untuk Fortify (boleh pilih salah satu gaya di bawah)
        // Gaya arrow function:
        if (class_exists('Laravel\\Fortify\\Fortify')) {
            // Panggil metode Fortify secara dinamis untuk menghindari kesalahan saat paket Fortify tidak terpasang
            call_user_func(['Laravel\\Fortify\\Fortify', 'loginView'], fn () => view('auth.login'));
            call_user_func(['Laravel\\Fortify\\Fortify', 'registerView'], fn () => view('auth.register'));
        }

        // Atau kalau masih merah, pakai closure biasa:
        // Fortify::loginView(function () { return view('auth.login'); });
        // Fortify::registerView(function () { return view('auth.register'); });
    }
}
