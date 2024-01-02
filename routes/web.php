<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [RegistrationController::class, 'index'])->name('registration');
Route::post('/', [RegistrationController::class, 'store']);

Route::post('/update', [RegistrationController::class, 'update'])->name('registration.update');
Route::delete('/delete', [RegistrationController::class, 'delete'])->name('registration.delete');
