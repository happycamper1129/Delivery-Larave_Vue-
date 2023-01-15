<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\Role\RolesController;
use App\Http\Controllers\User\ProfileController;
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    /**
     * Profile ROute
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile', [ProfileController::class, 'avatarUpdate'])->name('profile.image');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * Role Route
     */
    Route::resource('role', RolesController::class, ['except' => ['update']]);
    Route::post('/role/update/{role}', [RolesController::class, 'update'])->name('role.update');

    /**
     * User Route
     */
    Route::resource('user', UserController::class, ['except' => ['update']]);
    Route::post('/user/update/{user}', [UserController::class, 'update'])->name('user.update');
    Route::post('/user/image/{user}', [UserController::class, 'avatarUpdate'])->name('user.image.update');
    Route::delete('/user/image/{user}', [UserController::class, 'avatarDelete'])->name('user.image.destroy');

    /**
     * Options Route
     */
    Route::resource('options', OptionController::class, ['except' => ['update']]);
    Route::post('/options/update/{option:option_key}', [OptionController::class, 'update'])->name('options.update');
    Route::patch('/options/update', [OptionController::class, 'bulkUpdate'])->name('options.bulk.update');

    /**
     * Image Route
     */
    Route::resource('image', ImageController::class, ['except' => ['update']]);

    Route::resource('address', AddressController::class, ['except' => ['update', 'index', 'edit']]);
    Route::post('/address/update/{address}', [AddressController::class, 'update'])->name('address.update');

    Route::post('mark-read', [NotificationController::class, 'markNotification'])
    ->name('notification.mark.read');
});

require __DIR__.'/auth.php';
