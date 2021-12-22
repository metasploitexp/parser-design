<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\ProjectController;

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

Route::get('/parser', [MainController::class, 'parser']);

Route::get('/parser/projects', [MainController::class, 'parserProjects']);

Route::get('/designers', [DesignerController::class, 'designers']);

Route::get('/designers/{id}', [DesignerController::class, 'choosen']);

Route::get('/projects/{id}', [ProjectController::class, 'project']);
