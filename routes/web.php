<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\NewsController;

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

Route::get('/', [PageController::class, 'homepage']);
Route::get('p/{id}', [PageController::class, 'user_index'])->name('user.page');
Route::get('training', [TrainingController::class, 'user_index'])->name('user.training');
Route::get('training/{id}', [TrainingController::class, 'user_detail'])->name('user.training_detail');
Route::get('trainee', [TraineeController::class, 'user_index'])->name('user.trainee');
Route::get('trainee/{id}', [TraineeController::class, 'user_detail'])->name('user.trainee_detail');
Route::get('news', [NewsController::class, 'user_index'])->name('user.news');
Route::get('news/{id}', [NewsController::class, 'user_detail'])->name('user.news_detail');
