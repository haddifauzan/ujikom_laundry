<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\JenisLaundryController;
use App\Http\Controllers\TarifLaundryController;
use App\Http\Controllers\LayananTambahanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PemakaianBarangController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\KasirTransaksiController;
use App\Http\Controllers\StatusPesananController;
use App\Http\Controllers\PengambilanController;
use App\Http\Controllers\RiwayatTransaksiController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\HomeSettingsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\KasirDashboardController;
use App\Http\Controllers\PengelolaBarangDashboardController;
use App\Http\Controllers\LaporanBarangController;
use App\Http\Controllers\LaporanTransaksiController;
use App\Http\Controllers\LogAktivitasController;
use Illuminate\Support\Facades\Http;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/about-us', [LandingController::class, 'about'])->name('landing.about');
Route::get('/services', [LandingController::class, 'services'])->name('landing.services');
Route::post('/reviews/submit', [LandingController::class, 'submitReview'])->name('reviews.submit');

Route::get('/login-pegawai', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login-form', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login-submit', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/member/login-modal', [AuthController::class, 'showLoginModal'])->name('member.login.modal');
Route::get('/member/login', [AuthController::class, 'showMemberLoginForm'])->name('member.login');
Route::post('/member/login', [AuthController::class, 'memberLogin'])->name('member.login.submit');
Route::post('/member/logout', [AuthController::class, 'memberLogout'])->name('member.logout');
Route::get('/member/data', [AuthController::class, 'getMemberData'])->name('member.data');

Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin'], function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::post('/update-account', [AdminDashboardController::class, 'updateAccount'])->name('admin.updateAccount');

    Route::resource('karyawan', KaryawanController::class);
    Route::resource('jenis-laundry', JenisLaundryController::class);
    Route::resource('tarif-laundry', TarifLaundryController::class);
    Route::resource('layanan-tambahan', LayananTambahanController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('voucher', VoucherController::class);

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users/status/{id}', [UserController::class, 'updateStatus']);

    Route::get('/konsumen', [KonsumenController::class, 'index'])->name('konsumen.index');
    Route::delete('/konsumen/{id}', [KonsumenController::class, 'destroy'])->name('konsumen.destroy');

    Route::get('/settings/home', [HomeSettingsController::class, 'index'])->name('settings.home');
    Route::put('/settings/home/update', [HomeSettingsController::class, 'update'])->name('settings.home.update');
    
    // Review Management Routes
    Route::put('/reviews/{review}/toggle', [ReviewController::class, 'toggleDisplay'])->name('reviews.toggle');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/laporan-barang', [LaporanBarangController::class, 'index'])->name('admin.laporan-barang.index');
    Route::get('/laporan-barang/print', [LaporanBarangController::class, 'print'])->name('admin.laporan-barang.print');

    Route::get('/laporan-transaksi', [LaporanTransaksiController::class, 'index'])->name('admin.laporan-transaksi.index');
    Route::get('/laporan-transaksi/print', [LaporanTransaksiController::class, 'print'])->name('admin.laporan-transaksi.print');
    Route::get('/laporan-transaksi/{id}/detail', [LaporanTransaksiController::class, 'detail'])->name('admin.laporan-transaksi.detail');

    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log-aktivitas.index');
});

// Karyawan routes - Only accessible by Karyawan role
Route::group(['middleware' => ['auth:karyawan', 'check.karyawan.status:pengelola barang']], function () {
    Route::get('karyawan/pengelola-barang/dashboard', [PengelolaBarangDashboardController::class, 'index'])->name('karyawan.pengelola-barang.dashboard');
    Route::get('karyawan/pengelola-barang/dashboard/chart-data', [PengelolaBarangDashboardController::class, 'getChartData'])->name('karyawan.pengelola-barang.dashboard.chart-data');

    Route::put('karyawan/pengelola-barang/profile/update', [KaryawanController::class, 'update_profile'])
        ->name('karyawan.pengelola-barang.profile.update');

    Route::get('karyawan/pengelola-barang/data-barang', [BarangController::class, 'index_karyawan'])->name('karyawan.pengelola-barang.data-barang');

    Route::get('karyawan/pengelola-barang/barang-masuk', [PembelianController::class, 'index'])->name('barang-masuk.index');
    Route::post('karyawan/pengelola-barang/pembelian', [PembelianController::class, 'store'])->name('karyawan.pembelian.store');
    Route::get('karyawan/pengelola-barang/pembelian/{id}/detail', [PembelianController::class, 'show'])->name('pembelian.show');
    Route::get('karyawan/pengelola-barang/pembelian/{id}/cetak', [PembelianController::class, 'cetakInvoice'])->name('pembelian.cetak');
    Route::get('/pembelian/laporan', [PembelianController::class, 'cetakLaporan'])->name('karyawan.pembelian.laporan');

    Route::get('karyawan/pengelola-barang/pemakaian-barang', [PemakaianBarangController::class, 'index'])->name('karyawan.pemakaian-barang.index');
    Route::post('karyawan/pengelola-barang/pemakaian-barang', [PemakaianBarangController::class, 'store'])->name('karyawan.pemakaian-barang.store');
    Route::get('karyawan/pengelola-barang/pemakaian-barang/laporan/date-range', [PemakaianBarangController::class, 'getLaporanByDateRange'])->name('karyawan.pemakaian-barang.laporan.date-range');
    Route::get('karyawan/pengelola-barang/pemakaian-barang/laporan/by-barang', [PemakaianBarangController::class, 'getLaporanByBarang'])->name('karyawan.pemakaian-barang.laporan.by-barang');
    Route::get('karyawan/pengelola-barang/pemakaian-barang/cetak-laporan', [PemakaianBarangController::class, 'cetakLaporan'])->name('karyawan.pemakaian-barang.cetak-laporan');
});

// Karyawan routes - Only accessible by Karyawan role
Route::group(['middleware' => ['auth:karyawan', 'check.karyawan.status:kasir']], function () {
    Route::get('/kasir/dashboard', [KasirDashboardController::class, 'index'])->name('karyawan.kasir.dashboard');
    Route::get('/kasir/dashboard/chart-data', [KasirDashboardController::class, 'getChartData'])->name('kasir.dashboard.chart-data');
    Route::put('/profile/update', [KaryawanController::class, 'update_profile'])
         ->name('karyawan.kasir.profile.update');

    Route::get('/transaksi/step1', [KasirTransaksiController::class, 'step1'])->name('transaksi.step1');
    Route::get('/konsumen/search', [KasirTransaksiController::class, 'searchKonsumen'])->name('konsumen.search');
    Route::post('/konsumen/store', [KasirTransaksiController::class, 'storeKonsumen'])->name('konsumen.store');
    Route::get('/transaksi/member/invoice/{id_konsumen}', [KasirTransaksiController::class, 'memberInvoice'])->name('transaksi.member.invoice');

    Route::get('/transaksi/step2/{id_konsumen}', [KasirTransaksiController::class, 'step2'])->name('transaksi.step2');
    Route::get('/get-tarif/{id_jenis}', [KasirTransaksiController::class, 'getTarif'])->name('get-tarif');
    Route::get('/get-layanan/{id_layanan}', [KasirTransaksiController::class, 'getLayanan'])->name('get-layanan');

    Route::get('/transaksi/step3/{id_konsumen}', [KasirTransaksiController::class, 'step3'])->name('transaksi.step3');
    Route::post('/check-voucher', [KasirTransaksiController::class, 'checkVoucher'])->name('kasir.check-voucher');

    Route::get('/transaksi/step4/{id_konsumen}', [KasirTransaksiController::class, 'step4'])->name('transaksi.step4');
    Route::post('/transaksi/process', [KasirTransaksiController::class, 'processPayment'])->name('kasir.transaksi.process');
    Route::get('/transaksi/{id_transaksi}/invoice', [KasirTransaksiController::class, 'invoice'])->name('kasir.transaksi.invoice');

    Route::get('/karyawan/kasir/pesanan', [StatusPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/karyawan/kasir/pesanan/show/{id}', [StatusPesananController::class, 'show'])->name('pesanan.show');
    Route::post('/karyawan/kasir/pesanan/update-status/{id}', [StatusPesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

    Route::get('/pengambilan', [PengambilanController::class, 'index'])->name('pengambilan.index');
    Route::post('/pengambilan/verify-qr', [PengambilanController::class, 'verifyQR'])->name('pengambilan.verify-qr');
    Route::post('/pengambilan/complete', [PengambilanController::class, 'complete'])->name('pengambilan.complete');

    Route::get('/riwayat', [RiwayatTransaksiController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/detail/{id}', [RiwayatTransaksiController::class, 'detail'])->name('riwayat.detail');
    Route::get('/riwayat/print', [RiwayatTransaksiController::class, 'print'])->name('riwayat.print');
});

// Konsumen routes - Only accessible by Konsumen role
Route::group(['middleware' => 'auth:konsumen'], function () {
    Route::get('/member', [LandingController::class, 'index'])->name('landing.member');
    Route::get('/member/about-us', [LandingController::class, 'about'])->name('landing.about.member');
    Route::get('/member/services', [LandingController::class, 'services'])->name('landing.services.member');
    Route::get('/member/vouchers', [MemberController::class, 'vouchers'])->name('member.vouchers');
    Route::get('/member/orders/tracking', [MemberController::class, 'orderTracking'])->name('member.order.tracking');
    Route::get('/member/transactions', [MemberController::class, 'transactions'])->name('member.transactions');
    Route::get('/member/profile', [MemberController::class, 'profile'])->name('member.profile');
    Route::get('/member/profile/data', [AuthController::class, 'getProfileData'])->name('member.profile.data');
});


Route::get('/test-wablas', function () {
    $phone = '6282119997664';
    $message = 'Ini adalah pesan uji coba dari Wablas API.';

    $response = Http::withHeaders([
        'Authorization' => config('services.wablas.token'),
    ])->post(config('services.wablas.base_url') . '/send-message', [
        'phone' => $phone,
        'message' => $message,
    ]);

    if ($response->successful()) {
        return response()->json(['status' => 'success', 'data' => $response->json()]);
    } else {
        return response()->json(['status' => 'failed', 'error' => $response->json()]);
    }
});

