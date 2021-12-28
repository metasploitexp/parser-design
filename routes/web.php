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
Route::get('/designers/create', [DesignerController::class, 'create']);
Route::get('/designers/edit/{id}', [DesignerController::class, 'edit']);
Route::post('/designers/create/submit', [DesignerController::class, 'submit'])->name('designer-create');
Route::post('/designers/edit/submit', [DesignerController::class, 'update'])->name('designer-edit');
Route::get('/designers/{id}', [DesignerController::class, 'choosen']);

Route::get('/projects/create', [ProjectController::class, 'create'])->name('create');
Route::get('/projects/edit/{id}', [ProjectController::class, 'edit'])->name('edit');
Route::post('/projects/create/submit', [ProjectController::class, 'submit'])->name('project-create');
Route::post('/projects/edit/submit', [ProjectController::class, 'update'])->name('project-edit');
Route::get('/projects/{id}', [ProjectController::class, 'project']);
