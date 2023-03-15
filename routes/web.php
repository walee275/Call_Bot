<?php

use App\Http\Controllers\CallBotController;
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
    return view('homepage');
})->name('create');


Route::controller(CallBotController::class)->group(function () {

    Route::get('users/all', 'show_users')->name('show.users');
    Route::post('add/user', 'user_add')->name('add.user');
    Route::post('add/audio', 'add_audio')->name('add.audio');
});

