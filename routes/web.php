<?php

use App\Http\Livewire\FormInput;
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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('login/index');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/penerimaan-barang', function () {
        return view('penerimaan-barang');
    });
});
Route::get('/logout', [FormInput::class, 'logout'])->name('logout');
Route::post('/upload', [FormInput::class, 'store'])->name('dropzone.store');
