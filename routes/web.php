<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('funds',App\Http\Controllers\Staff\FundController::class)->names('staff.funds');
    Route::resource('fund/{fund}/items',App\Http\Controllers\Staff\FundItemController::class)->names('staff.fund.items');
    Route::resource('fund/{fund}/expends',App\Http\Controllers\Staff\ExpendController::class)->names('staff.fund.expends');
    Route::resource('expend/{expend}/items',App\Http\Controllers\Staff\ExpendItemController::class)->names('staff.expend.items');


});
Route::group([
    'prefix' => '/admin',
    'middleware' => [
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'role:admin'
    ]
], function () {
    Route::get('/',[App\Http\Controllers\Admin\DashboardController::class,'index'])->name('admin.dashboard');
    Route::resource('configs',App\Http\Controllers\Admin\ConfigController::class)->names('admin.configs');
    Route::resource('categories',App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories');
    Route::resource('category/{category}/items',App\Http\Controllers\Admin\CategoryItemController::class)->names('admin.category.items');
    Route::resource('category/item/{item}/accounts',App\Http\Controllers\Admin\CategoryItemAccountController::class)->names('admin.category.item.accounts');
    Route::resource('funds',App\Http\Controllers\Admin\FundController::class)->names('admin.funds');
    Route::resource('fund/{fund}/items',App\Http\Controllers\Admin\FundItemController::class)->names('admin.fund.items');
    Route::resource('fund/{fund}/expends',App\Http\Controllers\Admin\ExpendController::class)->names('admin.fund.expends');
    Route::resource('expend/{expend}/items',App\Http\Controllers\Admin\ExpendItemController::class)->names('admin.expend.items');
    Route::post('fund/{fund}/toggle_close',[App\Http\Controllers\Admin\FundController::class,'toggleClose'])->name('admin.fund.toggleClose');
    Route::post('expend/{expend}/toggle_lock',[App\Http\Controllers\Admin\ExpendController::class,'toggleLock'])->name('admin.expend.toggleLock');
    Route::post('expend/{expend}/toggle_close',[App\Http\Controllers\Admin\ExpendController::class,'toggleClose'])->name('admin.expend.toggleClose');
});

