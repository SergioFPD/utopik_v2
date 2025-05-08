<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\NavController;
use Illuminate\Http\Request;

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

// PRUEBAS ----------------------
Route::get('/pin', function () {
    return view('pin'); // Vista donde se introduce el PIN
})->name('pin.form');

Route::post('/pin', function (Request $request) {
    $correctPin = env("PIN_ACCESO");

    if ($request->pin == $correctPin) {
        session(['pin_verified' => true]);
        return redirect()->route('home');
    }

    return view('pin');

})->name('pin.verify');


// LANGUAGE
Route::get('/lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang');

// NAVIGATION ( PIN DE PRUEBAS )
Route::middleware(['pin'])->group(function () {
    Route::get('/', [NavController::class, 'home'])->name('home');
    // Verifica que el pais este activo
    Route::get('/country/{country}', [NavController::class, 'country'])->name('country')->middleware('country');
    Route::get('/experience/detail/{experience}', [NavController::class, 'viewDetail'])->name('experience.detail')->middleware('country');
});

// ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/profiles/admin-profile/{menu}', [AdminController::class, 'viewProfile'])->name('admin.profile');


    // Route modal form customer modify
    Route::get('/form/customer/{id}', [AdminController::class, 'formCustomer'])->name('form.customer');
    Route::put('/admin/customer/update/{user}', [AdminController::class, 'updateCustomer'])->name('admin.customer.update');
    Route::delete('/admin/customer/delete/{user}', [AdminController::class, 'deleteCustomer'])->name('admin.customer.delete');
    // Route modal form country
    Route::get('/form/country/{id}', [AdminController::class, 'formCountry'])->name('form.country');
    Route::post('/admin/store/country', [AdminController::class, 'storeCountry'])->name('admin.store.country');
    Route::put('/admin/update/country/{id}', [AdminController::class, 'updateCountry'])->name('admin.update.country');
    // Route modal form provider
    Route::get('/form/provider/{id}', [AdminController::class, 'formProvider'])->name('form.provider');
    Route::post('/admin/store/provider', [AdminController::class, 'storeProvider'])->name('admin.store.provider');
    Route::put('/admin/update/provider/{id}', [AdminController::class, 'updateProvider'])->name('admin.update.provider');
});

// PROVIDER
Route::middleware(['auth', 'role:proveedor'])->group(function () {

    Route::get('/check-name/{name}', [ProviderController::class, 'checkName'])->name('check.name');

    Route::get('/profiles/prov-profile/{menu}', [ProviderController::class, 'viewProviderProfile'])->name('provider.profile');

    Route::get('/experience/form', [ProviderController::class, 'experienceCreateForm'])->name('experience.form');
    Route::get('/activity/form/{exp_id}/{act_id}/{mode}', [ProviderController::class, 'activityListForm'])->name('activity.form');

    Route::post('/experience/store', [ProviderController::class, 'storeExperience'])->name('experience-store');
    Route::get('/experience/modify/{id}', [ProviderController::class, 'experienceModifyForm'])->name('experience.modify');
    Route::post('/experience/update/{id}', [ProviderController::class, 'updateExperience'])->name('experience.update');

    Route::post('/activity/store', [ProviderController::class, 'storeActivity'])->name('activity.store');
    Route::post('/activity/update/{id}', [ProviderController::class, 'updateActivity'])->name('activity.update');
    Route::delete('/activity/delete/{id}', [ProviderController::class, 'deleteActivity'])->name('activity.delete');
    // Evaluation modal form
    Route::get('/form/evaluate/{id}', [ProviderController::class, 'formEvaluate'])->name('form.evaluate');
    Route::put('/rate/customer/{id}', [ProviderController::class, 'rateCustomer'])->name('rate.customer');
});

// CUSTOMER
Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::get('/profiles/client-profile/{menu}', [UserController::class, 'viewClientProfile'])->name('client.profile');
    Route::post('/client/store/reserve', [UserController::class, 'storeReserve'])->name('reserve.store');
    Route::put('/client/update/user', [UserController::class, 'updateUser'])->name('client.update.user');
    // Route modal form reservation
    Route::get('/form/reserve/{experience}', [NavController::class, 'formReserve'])->name('form.reserve');
});

// GUEST
Route::middleware(['guest', 'blocked'])->group(function () {
    Route::get('/provider/login', [NavController::class, 'providerLogin'])->name('provider.login');
    Route::post('/login/user', [LoginController::class, 'loginUser'])->middleware('guest')->name('login.user');
    Route::post('/login/provider', [LoginController::class, 'loginProvider'])->middleware('guest')->name('login.provider');
    Route::post('/register/user', [RegisterController::class, 'registerUser'])->name('register.user');
});


// ALL AUTH
Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
});
