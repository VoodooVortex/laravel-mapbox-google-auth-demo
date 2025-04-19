<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckGoogleLogin;
use App\Http\Controllers\MapController;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;


Route::middleware([CheckGoogleLogin::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/user-edit', [UserController::class, 'index'])->name('edit.users');
    Route::post('/user-edit', [UserController::class, 'addNewUser'])->name('add.new.user');
    Route::delete('/user-edit', [UserController::class, 'deleteUser'])->name('delete.user');
    Route::put('/user-edit/{$id}', [UserController::class, 'editUser'])->name('edit.user');
});


Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/logout', function () {
    Session::forget('google_user');
    Session::flush();
    Auth::logout();
    return Redirect('/login');
})->name('logout');

Route::get('/map', [MapController::class, 'index'])->name('map');


Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('redirect.google');

Route::get('auth/google/callback', [GoogleController::class, 'googleCallback'])->name('callback.google');
