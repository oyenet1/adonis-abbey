<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        // redirect to dashboard if the user role is admin or librarian else redirect to home
        return redirect('/home');
    }
    return view('auth.login');
});

Route::view('/template', 'layouts.dashboard');

Route::get('/dashboard', App\Http\Livewire\AllBooks::class)->middleware('auth');


Route::get('/home', App\Http\Livewire\Books::class)->name('library')->middleware('auth');;
Route::get('/profile', App\Http\Livewire\ImageUpload::class)->name('profile')->middleware('auth');
Route::get('/borrowers', App\Http\Livewire\Borrows::class)->name('admin.book')->middleware('role:admin|librarian');