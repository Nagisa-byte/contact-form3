<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/


Route::get('/', [ContactController::class, 'index']);
Route::post('/contacts/confirm', [ContactController::class, 'confirm']);
Route::post('/contacts/store', [ContactController::class, 'store']);
Route::post('/contacts/back', [ContactController::class, 'back']);
Route::middleware(['auth'])->group(function () {
    
});
Route::get('/admin', [ContactController::class, 'list'])->name('admin');
Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
