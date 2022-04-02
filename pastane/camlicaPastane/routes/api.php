<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\MobileController;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


####################################### Admin Side #######################################
Route::post('/createUser', [AdminController::class, 'createUser']);
Route::get('/users', [AdminController::class, 'users']);
Route::post('/getUser', [AdminController::class, 'getUser']);
Route::post('/getWeekWorks', [AdminController::class, 'getWeekWorks']);
Route::post('/getAllWorks', [AdminController::class, 'getAllWorks']);
Route::post('/changeName', [AdminController::class, 'changeName']);
Route::post('/editedWork', [AdminController::class, 'editedWork']);
Route::post('/getDaysValues', [AdminController::class, 'getDaysValues']);
Route::get('/getWeekAllWorks', [AdminController::class, 'getWeekAllWorks']);
Route::post('/sendNote', [AdminController::class, 'sendNote']);
Route::get('/getNotes', [AdminController::class, 'getNotes']);
Route::post('/sendMessage', [AdminController::class, 'sendMessage']);
Route::get('/getMessage', [AdminController::class, 'getMessage']);

Route::post('/deleteNote', [AdminController::class, 'deleteNote']);
Route::get('/deleteMessage', [AdminController::class, 'deleteMessage']);
Route::post('/getDaysAllValues', [AdminController::class, 'getDaysAllValues']);
################### Price Things ###################
Route::post('/changePrice', [AdminController::class, 'changePrice']);
Route::get('/getPrice', [AdminController::class, 'getPrice']);
Route::post('/getWeekWorksForPrice', [AdminController::class, 'getWeekWorksForPrice']);
Route::post('/getAllWorksForPrice', [AdminController::class, 'getAllWorksForPrice']);
Route::get('/getWeekAllWorksForPrice', [AdminController::class, 'getWeekAllWorksForPrice']);
Route::post('/getDaysAllValuesForPrice', [AdminController::class, 'getDaysAllValuesForPrice']);
################### Price Things ###################
################### Excel Things ###################
Route::post('/exportTheUser', [ExcelController::class, 'exportTheUser']);
################### Excel Things ###################

####################################### Admin Side #######################################





####################################### Mobile Side #######################################
Route::get('/getWorkList', [MobileController::class, 'getWorkList']);
Route::get('/getUserList', [MobileController::class, 'getUserList']);
Route::post('/createWork', [MobileController::class, 'createWork']);
Route::post('/deleteWork', [MobileController::class, 'deleteWork']);
Route::get('/message', [MobileController::class, 'message']);
####################################### Mobile Side #######################################
