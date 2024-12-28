<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\LinkGroupController;
use App\Http\Controllers\LinkStatsController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\TrackerController;
use App\Http\Controllers\UserController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/register', fn() => redirect()->route('login'));

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['auth']);


Route::group(['prefix' => 'networks', 'middleware' => ['auth']], function () {

    Route::get('/', [NetworkController::class, 'index'])->name('networks.index');
    Route::any('add', [NetworkController::class, 'add'])->name('networks.add');
    Route::any('edit/{id}', [NetworkController::class, 'edit'])->name('networks.edit');
    Route::get('delete/{id}', [NetworkController::class, 'delete'])->name('networks.delete');

});

Route::group(['prefix' => 'link-groups', 'middleware' => ['auth']], function () {

    Route::get('/', [LinkGroupController::class, 'index'])->name('link_groups.index');
    Route::any('add', [LinkGroupController::class, 'add'])->name('link_groups.add');
    Route::any('edit/{id}', [LinkGroupController::class, 'edit'])->name('link_groups.edit');
    Route::get('delete/{id}', [LinkGroupController::class, 'delete'])->name('link_groups.delete');

});

Route::group(['prefix' => 'tracking-links', 'middleware' => ['auth']], function () {
    Route::get('/', [TrackerController::class, 'index'])->name('trackingLinks.index');
    Route::any('add', [TrackerController::class, 'add'])->name('trackingLinks.add');
    Route::any('edit/{id}', [TrackerController::class, 'edit'])->name('trackingLinks.edit');
    Route::get('delete/{id}', [TrackerController::class, 'delete'])->name('trackingLinks.delete');
});

Route::group(['prefix' => 'links', 'middleware' => ['auth']], function () {
    Route::get('/', [LinkController::class, 'index'])->name('links.index');
    Route::any('add', [LinkController::class, 'add'])->name('links.add');
    Route::any('edit/{id}', [LinkController::class, 'edit'])->name('links.edit');
    Route::get('delete/{id}', [LinkController::class, 'delete'])->name('links.delete');
});

Route::group(['prefix' => 'link-stats', 'middleware' => ['auth']], function () {
    Route::get('/', [LinkStatsController::class, 'index'])->name('linkStats.index');
    Route::post('detail', [LinkStatsController::class, 'detail'])->name('linkStats.detail');
    Route::get('reports/{id}/{category?}', [LinkStatsController::class, 'reports'])->name('linkStats.reports');
    Route::get('delete/{id}', [LinkStatsController::class, 'delete'])->name('linkStats.delete');
    Route::get('delete-detail/{id}', [LinkStatsController::class, 'deleteLinkDetail'])->name('linkStats.deleteDetail');
});

Route::group(['prefix' => 'users', 'middleware' => ['auth']], function () {

    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::any('add', [UserController::class, 'add'])->name('users.add');
    Route::any('edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::get('delete/{id}', [UserController::class, 'delete'])->name('users.delete');

});

Route::post('sale/clickbank', [TrackerController::class, 'trackClickBankSale'])->name('trackClickBankSale');
Route::get('{action}/{slug}/{keyword?}/{query?}/{adgroup?}/{network?}/{siteLinksExt?}', [TrackerController::class, 'track'])->name('track');
