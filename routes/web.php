<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Master\DashboardController;

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


Route::get('/language/{language}', function ($language) {
    Session::put('applocale', $language);
    return Redirect::back();
})->name('language');


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return Inertia::render('Staff/Dashboard');
//     })->name('dashboard');
//     Route::resource('funds',App\Http\Controllers\Staff\FundController::class)->names('staff.funds');
//     Route::resource('fund/{fund}/items',App\Http\Controllers\Staff\FundItemController::class)->names('staff.fund.items');
//     Route::resource('fund/{fund}/budgets',App\Http\Controllers\Staff\BudgetController::class)->names('staff.fund.budgets');
//     Route::resource('budget/{budget}/items',App\Http\Controllers\Staff\BudgetItemController::class)->names('staff.budget.items');

// });

Route::group([
    'prefix' => '/staff',
    'middleware' => [
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ]
], function () {
    Route::get('dashboard', function () {
        return Inertia::render('Staff/Dashboard');
    })->name('staff.dashboard');
    Route::resource('funds',App\Http\Controllers\Staff\FundController::class)->names('staff.funds');
    Route::resource('fund/{fund}/items',App\Http\Controllers\Staff\FundItemController::class)->names('staff.fund.items');
    Route::resource('fund/{fund}/budgets',App\Http\Controllers\Staff\BudgetController::class)->names('staff.fund.budgets');
    Route::resource('budget/{budget}/items',App\Http\Controllers\Staff\BudgetItemController::class)->names('staff.budget.items');

});

Route::group([
    'prefix' => '/admin',
    'middleware' => [
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'role:dei|gf'
    ]
], function () {
    Route::get('dashboard',[App\Http\Controllers\Admin\DashboardController::class,'index'])->name('admin.dashboard');
    Route::resource('categories',App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories');
    Route::resource('category/{category}/items',App\Http\Controllers\Admin\CategoryItemController::class)->names('admin.category.items');
    Route::resource('category/item/{item}/accounts',App\Http\Controllers\Admin\CategoryItemAccountController::class)->names('admin.category.item.accounts');
    Route::resource('funds',App\Http\Controllers\Admin\FundController::class)->names('admin.funds');
    Route::resource('fund/{fund}/items',App\Http\Controllers\Admin\FundItemController::class)->names('admin.fund.items');
    Route::resource('fund/{fund}/budgets',App\Http\Controllers\Admin\BudgetController::class)->names('admin.fund.budgets');
    Route::resource('budget/{budget}/items',App\Http\Controllers\Admin\BudgetItemController::class)->names('admin.budget.items');
    Route::post('fund/{fund}/toggle_submit',[App\Http\Controllers\Admin\FundController::class,'toggleSubmit'])->name('admin.fund.toggleSubmit');
    Route::post('fund/{fund}/toggle_close',[App\Http\Controllers\Admin\FundController::class,'toggleClose'])->name('admin.fund.toggleClose');
    Route::post('budget/{budget}/toggle_submit',[App\Http\Controllers\Admin\BudgetController::class,'toggleSubmit'])->name('admin.budget.toggleSubmit');
    Route::post('budget/{budget}/toggle_lock',[App\Http\Controllers\Admin\BudgetController::class,'toggleLock'])->name('admin.budget.toggleLock');
    Route::post('budget/{budget}/toggle_close',[App\Http\Controllers\Admin\BudgetController::class,'toggleClose'])->name('admin.budget.toggleClose');
    Route::post('budget/{budget}/change_status',[App\Http\Controllers\Admin\BudgetController::class,'changeStatus'])->name('admin.budget.changeStatus');
    Route::get('fund/{fund}/export',[App\Http\Controllers\Admin\FundController::class,'export'])->name('admin.fund.export');
    Route::get('budget/{budget}/export',[App\Http\Controllers\Admin\BudgetController::class,'export'])->name('admin.budget.export');
    Route::resource('expends',App\Http\Controllers\Admin\ExpendController::class)->names('admin.expends');
    Route::resource('expend/items',App\Http\Controllers\Admin\ExpendItemController::class)->names('admin.expend.items');
});


Route::group([
    'prefix' => '/master',
    'middleware' => [
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'role:master'
    ]
], function () {
    Route::get('/',[App\Http\Controllers\Master\DashboardController::class,'index'])->name('master.dashboard');
    Route::resource('configs',App\Http\Controllers\Master\ConfigController::class)->names('master.configs');

});

Route::get('/debug-roles', function () {
    $user = auth()->user();
    dd([
        'user' => $user->name,
        'roles' => $user->getRoleNames(),
        'permissions' => $user->getAllPermissions()->pluck('name'),
    ]);
});

