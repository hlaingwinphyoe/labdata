<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

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

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function (){
    Route::get('/',[PageController::class,'index'])->name('index');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('/hospital',\App\Http\Controllers\HospitalController::class);
    Route::resource('/department',\App\Http\Controllers\DepartmentController::class);
    Route::resource('/test_type',\App\Http\Controllers\TestTypeController::class);
    Route::resource('/test_value',\App\Http\Controllers\TestTypeValueController::class);


    Route::post('/test_form',[PageController::class,'testTypeByDepartment'])->name('test_value.testTypeByDepartment');
    Route::get('/listings',[PageController::class,'listing'])->name('listing');
    // export excel file
    Route::get('data_export',[PageController::class,'getTestValueData'])->name('data.export');

    // Custom User Register
    Route::middleware('AdminOnly')->group(function(){
        Route::get('/users', [\App\Http\Controllers\PageController::class, 'users'])->name('users');
        Route::post('/user-register', [\App\Http\Controllers\PageController::class, 'postRegistration'])->name('register.post');
        Route::delete('/user-delete/{id}', [\App\Http\Controllers\PageController::class, 'destroy'])->name('user.destroy');
        Route::post('/make-admin', [\App\Http\Controllers\PageController::class, 'makeAdmin'])->name('user.makeAdmin');

    });

    Route::prefix('profile')->group(function(){
        // Main Frame Route
        Route::get('/',[\App\Http\Controllers\ProfileController::class, 'profile'])->name('profile');
        Route::post('/change-password',[\App\Http\Controllers\ProfileController::class, 'changePassword'])->name('profile.changePassword');
        Route::post('/change-name',[\App\Http\Controllers\ProfileController::class, 'changeName'])->name('profile.changeName');
        Route::post('/change-email',[\App\Http\Controllers\ProfileController::class, 'changeEmail'])->name('profile.changeEmail');
        Route::post('/change-photo',[\App\Http\Controllers\ProfileController::class, 'changePhoto'])->name('profile.changePhoto');
        Route::post('/signature_thumbnails',[\App\Http\Controllers\ProfileController::class, 'signature'])->name('profile.signature');
    });


    // 404 page
    Route::get('/denied',[PageController::class,'denied'])->name('denied');

});
