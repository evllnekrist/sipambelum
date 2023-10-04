<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\LocalPotentialController;

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
// system ---- in ENGLISH ----------------------------------------------------- start
Route::group(['prefix' => 'api'], function () {
    Route::post('/get-statistics-trainee-of-training', [PageController::class, 'get_statistics_trainee_of_training']);
    Route::post('/get-selection-list', [PageController::class, 'get_options']);
    Route::post('/get-user-list', [PageController::class, 'get_list']);
    Route::post('/get-page-list', [PageController::class, 'get_list']);
    Route::post('/get-banner-list', [BannerController::class, 'get_list']);
    Route::post('/get-news-listfull', [NewsController::class, 'get_listfull']);
    Route::post('/get-news-list', [NewsController::class, 'get_list']);
    Route::post('/get-training-listfull', [TrainingController::class, 'get_listfull']);
    Route::post('/get-training-list', [TrainingController::class, 'get_list']);
    Route::post('/get-trainee-listfull', [TraineeController::class, 'get_listfull']);
    Route::post('/get-trainee-list', [TraineeController::class, 'get_list']);
    Route::post('/get-local-potential-listfull', [LocalPotentialController::class, 'get_listfull']);
    Route::post('/get-local-potential-list', [LocalPotentialController::class, 'get_list']);
  
    Route::middleware('auth')->group(function () {
        Route::post('/page/post-add', [PageController::class, 'post_add']);
        Route::post('/page/post-edit', [PageController::class, 'post_edit']);
        Route::post('/page/post-delete/{id}', [PageController::class, 'post_delete']);

        Route::post('/banner/post-add', [BannerController::class, 'post_add']);
        Route::post('/banner/post-edit', [BannerController::class, 'post_edit']);
        Route::post('/banner/post-delete/{id}', [BannerController::class, 'post_delete']);
    
        Route::post('/news/post-add', [NewsController::class, 'post_add']);
        Route::post('/news/post-edit', [NewsController::class, 'post_edit']);
        Route::post('/news/post-delete/{id}', [NewsController::class, 'post_delete']);
    
        Route::get('/training/post-act/{id}/{act}', [TrainingController::class, 'post_act']);
        Route::post('/training/post-add', [TrainingController::class, 'post_add']);
        Route::post('/training/post-edit', [TrainingController::class, 'post_edit']);
        Route::post('/training/post-delete/{id}', [TrainingController::class, 'post_delete']);
        
        Route::get('/trainee/post-act/{id}/{act}', [TraineeController::class, 'post_act']);
        Route::post('/trainee/post-add', [TraineeController::class, 'post_add']);
        Route::post('/trainee/post-edit', [TraineeController::class, 'post_edit']);
        Route::post('/trainee/post-delete/{id}', [TraineeController::class, 'post_delete']);
    
        Route::get('/local-potential/post-act/{id}/{act}', [LocalPotentialController::class, 'post_act']);
        Route::post('/local-potential/post-add', [LocalPotentialController::class, 'post_add']);
        Route::post('/local-potential/post-edit', [LocalPotentialController::class, 'post_edit']);
        Route::post('/local-potential/post-delete/{id}', [LocalPotentialController::class, 'post_delete']);
    });
});

Route::get('/', [PageController::class, 'homepage']);
Route::get('p/{id}', [PageController::class, 'user_index'])->name('user.page');
Route::get('training', [TrainingController::class, 'user_index'])->name('user.training');
Route::get('training/{id}', [TrainingController::class, 'user_detail'])->name('user.training_detail');
Route::get('trainee', [TraineeController::class, 'user_index'])->name('user.trainee');
Route::get('trainee/{id}', [TraineeController::class, 'user_detail'])->name('user.trainee_detail');
Route::get('news', [NewsController::class, 'user_index'])->name('user.news');
Route::get('news/{id}', [NewsController::class, 'user_detail'])->name('user.news_detail');

Route::get('/dashboard', function () {
    return view('pages-admin/dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');
Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'admin-katkab'], function () {
        Route::get('/users', [ProfileController::class, 'admin_index'])->name('admin.user');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('page', [PageController::class, 'admin_index'])->name('admin.page');
        Route::get('page/add', [PageController::class, 'form_add'])->name('admin.page.add');
        Route::get('page/edit/{id}', [PageController::class, 'form_edit'])->name('admin.page.edit');

        Route::get('banner', [BannerController::class, 'admin_index'])->name('admin.banner');
        Route::get('banner/add', [BannerController::class, 'form_add'])->name('admin.banner.add');
        Route::get('banner/edit/{id}', [BannerController::class, 'form_edit'])->name('admin.banner.edit');

        Route::get('news', [NewsController::class, 'admin_index'])->name('admin.news');
        Route::get('news/add', [NewsController::class, 'form_add'])->name('admin.news.add');
        Route::get('news/edit/{id}', [NewsController::class, 'form_edit'])->name('admin.news.edit');

        Route::get('training', [TrainingController::class, 'admin_index'])->name('admin.training');
        Route::get('training/add', [TrainingController::class, 'form_add'])->name('admin.training.add');
        Route::get('training/edit/{id}', [TrainingController::class, 'form_edit'])->name('admin.training.edit');

        Route::get('trainee', [TraineeController::class, 'admin_index'])->name('admin.trainee');
        Route::get('trainee/add', [TraineeController::class, 'form_add'])->name('admin.trainee.add');
        Route::get('trainee/edit/{id}', [TraineeController::class, 'form_edit'])->name('admin.trainee.edit');

        Route::get('business', [BusinessController::class, 'admin_index'])->name('admin.business');
        Route::get('business/add', [BusinessController::class, 'form_add'])->name('admin.business.add');
        Route::get('business/edit/{id}', [BusinessController::class, 'form_edit'])->name('admin.business.edit');

        Route::get('local-potential', [LocalPotentialController::class, 'admin_index'])->name('admin.local-potential');
        Route::get('local-potential/add', [LocalPotentialController::class, 'form_add'])->name('admin.local-potential.add');
        Route::get('local-potential/edit/{id}', [LocalPotentialController::class, 'form_edit'])->name('admin.local-potential.edit');
    });
});

require __DIR__.'/auth.php';
// system ---- in ENGLISH ----------------------------------------------------- end
