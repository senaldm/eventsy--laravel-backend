<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\ImageController;
use App\Http\Controllers\QRController;

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
    return view('upload');
});


Route::get('/planners', [PlannerController::class, 'index']);
Route::get('/getCurrentPlanner/{currentPlannerId}', [PlannerController::class, 'getCurrentPlanner']);
Route::post('/hire/{currentId}/{plannerId}', [PlannerController::class, 'addFriend']);


// Route::get('/upload', 'ImageController@showUploadForm')->name('upload.form');
// Route::get('/upload', [ImageController::class, 'showUploadForm'])->name('upload.form');
// Route::post('/upload', [ImageController::class], 'uploadImage')->name('upload');
// Route::get('/edit', [ImageController::class], 'showEditForm')->name('edit.form');
// Route::post('/edit', [ImageController::class], 'editImage')->name('edit.image');


Route::post('/QRcreate',[QRController::class,'createQR'])->name('createqr');
Route::resource('emp', 'QRController');


//QR code validate
Route::get('/validate/{userCode}',[QRController::class,'validateQR']);