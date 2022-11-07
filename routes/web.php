<?php

use App\Http\Controllers\EventController;
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
    return redirect('/events');
});

Route::get('{any}', function () {
    return view('layout.index');
})->where('any', '.*');

Route::prefix('events')->group(function () {
    Route::post('/getAll', [EventController::class, 'getEvents']);
    Route::post('/add',    [EventController::class, 'setEvent']);
    Route::post('/edit',   [EventController::class, 'editEvent']);
    Route::post('/delete', [EventController::class, 'deleteEvent']);
});
