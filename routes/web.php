<?php

use App\Http\Controllers\ApotekerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;

Route::middleware(['auth', 'ceklevel:admin'])->group(function () {
Route::get('/user', [LoginController::class, 'user'])->name('user.index');
Route::post('/user-store', [LoginController::class, 'store'])->name('user.store');
Route::get('/user/{id_user}/edit', [LoginController::class, 'edit'])->name('user.edit');
Route::put('/user/{id_user}', [LoginController::class, 'update'])->name('user.update');
Route::delete('/user/{id_user}', [LoginController::class, 'destroy'])->name('user.destroy');



});
Route::middleware(['auth', 'ceklevel:kasir,admin'])->group(function () {
  Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
  Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
  Route::get('/transaksi/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
  Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
  Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
});
Route::middleware('guest')->group(function () {
  Route::get('/', [LoginController::class, 'index'])->name('login');
  Route::get('/lgn', [LoginController::class, 'index']);
  Route::post('/proses-login', [LoginController::class, 'login_proses'])->name('proses-login');
  Route::post('/proses-reg', [RegisterBasic::class, 'reg'])->name('proses-reg');
});

Route::middleware('auth')->group(function () {
  Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
  Route::get('/apoteker', [ApotekerController::class, 'index']);
  //pasien

Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');
Route::post('/pasien', [PasienController::class, 'store'])->name('pasien.store');
Route::get('/pasien/{id_pasien}/edit', [PasienController::class, 'edit'])->name('pasien.edit');
Route::put('/pasien/{id_pasien}', [PasienController::class, 'update'])->name('pasien.update');
Route::delete('/pasien/{id_pasien}', [PasienController::class, 'destroy'])->name('pasien.destroy');

//obats
Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
Route::post('/obat_store', [ObatController::class, 'store'])->name('obat.store');
Route::get('/obat/{id}/edit', [ObatController::class, 'edit'])->name('obat.edit');
Route::put('/obat/{id}', [ObatController::class, 'update'])->name('obat.update');
Route::delete('/obat/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');

//stok
Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
Route::post('/stok_store', [StokController::class, 'store'])->name('stok.store');
Route::get('/stok/{id}/edit', [StokController::class, 'edit'])->name('stok.edit');
Route::put('/stok/{id}', [StokController::class, 'update'])->name('stok.update');
Route::delete('/stok/{id}', [StokController::class, 'destroy'])->name('stok.destroy');


Route::get('/tampil', [Analytics::class, 'index'])->name('dashboard-analytics');

  // Route lain yang memerlukan authentication
});
// Main Page Route




//login


//user


// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
