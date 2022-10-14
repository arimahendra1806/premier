<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Transaksi;
use App\Http\Controllers\Member;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

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
    return view('premier');
});

Route::get('/test', function () {
    return view('pos/laporan');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Login
Route::get('/newlogin', [AuthController::class, 'login']);

//Register
Route::get('/newregister', [AuthController::class, 'register']);

//Logout
Route::get('/logout', [AuthController::class, 'logout']);

//Postlogin
Route::POST('/postlogin', [AuthController::class, 'postlogin']);

//Reject
Route::get('/reject', [AuthController::class, 'reject'])->name('reject');

//Rejectrole
Route::get('/rejectrole', [AuthController::class, 'rejectrole'])->name('rejectrole');

Route::group(['middleware' => 'auth'], function(){

	//Dashboard
	Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth');

	//Role Pengawas, Admin
	Route::group(['middleware' => 'CheckRole:member, admin'], function(){
		Route::get('/member/profile', [Member::class, 'indexProfile']);
		Route::get('/member/profile/cetak/{id}', [Member::class, 'notaPdf']);
		Route::get('/member/editProfile/{id}', [Member::class, 'editProfile']);
		Route::post('/member/updateProfile/{id}', [Member::class, 'updateProfile']);
		Route::get('/member/editBukti/{id}', [Member::class, 'editBukti']);
		Route::post('/member/updateBukti/{id}', [Member::class, 'updateBukti']);

		Route::get('/member/daftarBooking', [Member::class, 'indexDaftar']);
		Route::post('/member/search',  [Member::class, 'searchDaftar']);

		Route::get('/member/createBooking', [Member::class, 'createTrx']);
		Route::post('/member/transaksi/store', [Member::class, 'storeTrx']);
		Route::post('/member/detailUser/store', [Member::class, 'storeDetail']);

		Route::get('/member/kontakAdmin', [Member::class, 'indexKontak']);
		Route::get('/member/caraPembayaran/{id}', [Member::class, 'indexExtra']);

	});

	//Role Admin
	Route::group(['middleware' => 'CheckRole:admin'], function(){
		Route::get('/admin/index', [Transaksi::class, 'index']);
		Route::post('/admin/search',  [Transaksi::class, 'search']);
		Route::get('/admin/konfirmasi', [Transaksi::class, 'indexKonfirmasi']);
		Route::post('/admin/konfirmasi/search',  [Transaksi::class, 'searchKonfirmasi']);
		Route::get('/admin/editKonfirmasi/{id}', [Transaksi::class, 'editKonfirmasi']);
		Route::post('/admin/updateKonfirmasi/{id}', [Transaksi::class, 'updateKonfirmasi']);
		Route::get('/admin/bookingOffline', [Transaksi::class, 'bookingOffline']);
		Route::post('/admin/bookingOffline/store', [Transaksi::class, 'storeBookingOffline']);
		Route::get('/admin/laporan', [Transaksi::class, 'indexLaporan']);
		Route::get('/admin/laporanOffline', [Transaksi::class, 'indexLaporanOffline']);
		Route::get('/admin/laporan/pdf/{daterange}', [Transaksi::class, 'laporanReportPdf']);
		Route::get('/admin/laporanOffline/pdf/{daterange}', [Transaksi::class, 'laporanOfflineReportPdf']);
		Route::get('/admin/showLaporan/{id}', [Transaksi::class, 'showLaporan']);
		Route::get('/admin/showLaporanOffline/{id}', [Transaksi::class, 'showLaporanOffline']);

		// Route::resource('/products','ProductController');
        Route::get('/product', [ProductController::class, 'index']);
        Route::get('/product/create', [ProductController::class, 'create']);
        Route::post('/product/store', [ProductController::class, 'store']);
        Route::get('/product/update/{id}', [ProductController::class, 'edit']);
        Route::post('/product/delete/{id}', [ProductController::class, 'destroy']);

		Route::get('/transcation', [TransactionController::class, 'index']);
		Route::post('/transcation/addproduct/{id}', [TransactionController::class, 'addProductCart']);
		Route::post('/transcation/removeproduct/{id}', [TransactionController::class, 'removeProductCart']);
		Route::post('/transcation/clear', [TransactionController::class, 'clear']);
		Route::post('/transcation/increasecart/{id}', [TransactionController::class, 'increasecart']);
		Route::post('/transcation/decreasecart/{id}', [TransactionController::class, 'decreasecart']);
		Route::post('/transcation/bayar', [TransactionController::class, 'bayar']);
		Route::get('/transcation/history', [TransactionController::class, 'history']);
		Route::get('/transcation/laporan/{id}', [TransactionController::class, 'laporan']);
        Route::get('/transcation/laporanToko/{id}', [TransactionController::class, 'laporanPdf']);
	});
});
