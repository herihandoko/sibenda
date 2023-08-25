<?php

use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaManagerController;
use App\Http\Controllers\Frontend\HomePageController;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Str;
// BPBD Master
use App\Http\Controllers\Admin\Master\StatusKorbanController;
use App\Http\Controllers\Admin\Master\KategoriKorbanController;
use App\Http\Controllers\Admin\Master\JenisHunianController;
use App\Http\Controllers\Admin\Master\JenisBencanaController;
use App\Http\Controllers\Admin\Master\JalurKomunikasiController;
// BPBD Input Data
use App\Http\Controllers\Admin\DataBencana\DataBencanaController;
use App\Http\Controllers\Admin\DataBencana\DataKejadianController;
use App\Http\Controllers\Admin\LokasiPengungsian\LokasiPengungsianController;
use App\Http\Controllers\Admin\DataKorban\DataKorbanController;
use App\Http\Controllers\Admin\DependentDropdownController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\DocumentationController;
use App\Http\Controllers\GalleryController;

Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('/laporan-kejadian', [HomePageController::class, 'laporankejadian'])->name('laporankejadian');
Route::get('/laporan-kejadian/fetch', [HomePageController::class, 'laporan_fetch'])->name('laporankejadian.fetch');
Route::get('/laporan-kejadian/buat-laporan', [HomePageController::class, 'laporan_add'])->name('laporankejadian.add');
Route::post('/laporan-kejadian/kirim', [HomePageController::class, 'laporan_store'])->name('laporankejadian.kirim');
Route::get('/data-bencana/dokumentasi/{slug}', [HomePageController::class, 'detail_data'])->name('data-bencana.dokumentasi');

Route::get('/data-bencana', [HomePageController::class, 'databencana'])->name('databencana');
Route::get('/grafik-kejadian', [HomePageController::class, 'grafik'])->name('grafik');
Route::get('/infografis', [HomePageController::class, 'infografis'])->name('infografis');
Route::get('/dokumentasi', [HomePageController::class, 'dokumentasi'])->name('dokumentasi');
Route::get('/kontak', [HomePageController::class, 'kontak'])->name('kontak');
Route::get('/kabkota', [HomePageController::class, 'kabkota'])->name('kabkota');
Route::get('/location', [HomePageController::class, 'location'])->name('location');
Route::get('/legends', [HomePageController::class, 'legends'])->name('legends');
Route::get('/databencana/fetch', [HomePageController::class, 'fetch_databencana'])->name('databencana.fetch');
Route::post('/kontak/store', [HomePageController::class, 'store'])->name('kontak.store');
Route::get('/databencana/chart', [HomePageController::class, 'fetch_chart'])->name('databencana.chart');
Route::get('/databencana/chart_city', [HomePageController::class, 'chart_city'])->name('databencana.chart_city');
Route::get('/dokumentasi/{slug}', [HomePageController::class, 'dokumentasi_detail'])->name('dokumentasi.detail');
// Daftar Indonesia
Route::get('/provinces', [DependentDropdownController::class, 'provinces'])->name('provinces');
Route::get('/cities', [DependentDropdownController::class, 'cities'])->name('cities');
Route::get('/districts', [DependentDropdownController::class, 'districts'])->name('districts');
Route::get('/villages', [DependentDropdownController::class, 'villages'])->name('villages');

Route::group(['middleware' => ['XSS', 'HtmlSpecialchars', 'prevent-back-history']], function () {
    Route::get('lang', function () {
        generateLangFrontend('views/frontend', 'lang/en/frontend.php');
        generateLangBackend('views/admin', 'lang/en/admin.php');
    });
    // Admin Routes
    Route::get('/admin/login', [AdminLoginController::class, 'adminLoginForm'])->name('admin.login');
    Route::get('/user/login', [AdminLoginController::class, 'adminLoginForm'])->name('user.login');
    Route::post('/admin/login', [AdminLoginController::class, 'adminCheckLogin'])->name('admin.login');
    Route::post('/admin/logout', [AdminLoginController::class, 'adminLogout'])->name('admin.logout');
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {
        // Dashoboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        // Master
        Route::get('/master/status_korban', [StatusKorbanController::class, 'index'])->name('master.status-korban.index');
        Route::get('/master/status_korban/create', [StatusKorbanController::class, 'create'])->name('master.status-korban.create');
        Route::post('/master/status_korban/store', [StatusKorbanController::class, 'store'])->name('master.status-korban.store');
        Route::get('/master/status_korban/edit/{id}', [StatusKorbanController::class, 'edit'])->name('master.status-korban.edit');
        Route::post('/master/status_korban/update/{id}', [StatusKorbanController::class, 'update'])->name('master.status-korban.update');
        Route::delete('/master/status_korban/destroy/{id}', [StatusKorbanController::class, 'destroy'])->name('master.status-korban.destroy');

        Route::get('/master/kategori_korban', [KategoriKorbanController::class, 'index'])->name('master.kategori-korban.index');
        Route::get('/master/kategori_korban/create', [KategoriKorbanController::class, 'create'])->name('master.kategori-korban.create');
        Route::post('/master/kategori_korban/store', [KategoriKorbanController::class, 'store'])->name('master.kategori-korban.store');
        Route::get('/master/kategori_korban/edit/{id}', [KategoriKorbanController::class, 'edit'])->name('master.kategori-korban.edit');
        Route::post('/master/kategori_korban/update/{id}', [KategoriKorbanController::class, 'update'])->name('master.kategori-korban.update');
        Route::delete('/master/kategori_korban/destroy/{id}', [KategoriKorbanController::class, 'destroy'])->name('master.kategori-korban.destroy');

        Route::get('/master/jenis_hunian', [JenisHunianController::class, 'index'])->name('master.jenis-hunian.index');
        Route::get('/master/jenis_hunian/create', [JenisHunianController::class, 'create'])->name('master.jenis-hunian.create');
        Route::post('/master/jenis_hunian/store', [JenisHunianController::class, 'store'])->name('master.jenis-hunian.store');
        Route::get('/master/jenis_hunian/edit/{id}', [JenisHunianController::class, 'edit'])->name('master.jenis-hunian.edit');
        Route::post('/master/jenis_hunian/update/{id}', [JenisHunianController::class, 'update'])->name('master.jenis-hunian.update');
        Route::delete('/master/jenis_hunian/destroy/{id}', [JenisHunianController::class, 'destroy'])->name('master.jenis-hunian.destroy');

        Route::get('/master/jenis_bencana', [JenisBencanaController::class, 'index'])->name('master.jenis-bencana.index');
        Route::get('/master/jenis_bencana/create', [JenisBencanaController::class, 'create'])->name('master.jenis-bencana.create');
        Route::post('/master/jenis_bencana/store', [JenisBencanaController::class, 'store'])->name('master.jenis-bencana.store');
        Route::get('/master/jenis_bencana/edit/{id}', [JenisBencanaController::class, 'edit'])->name('master.jenis-bencana.edit');
        Route::post('/master/jenis_bencana/update/{id}', [JenisBencanaController::class, 'update'])->name('master.jenis-bencana.update');
        Route::delete('/master/jenis_bencana/destroy/{id}', [JenisBencanaController::class, 'destroy'])->name('master.jenis-bencana.destroy');
        Route::post('/master/jenis_bencana/getName', [JenisBencanaController::class, 'getName'])->name('master.jenis-bencana.getName');

        Route::get('/master/jalur_komunikasi', [JalurKomunikasiController::class, 'index'])->name('master.jalur-komunikasi.index');
        Route::get('/master/jalur_komunikasi/create', [JalurKomunikasiController::class, 'create'])->name('master.jalur-komunikasi.create');
        Route::post('/master/jalur_komunikasi/store', [JalurKomunikasiController::class, 'store'])->name('master.jalur-komunikasi.store');
        Route::get('/master/jalur_komunikasi/edit/{id}', [JalurKomunikasiController::class, 'edit'])->name('master.jalur-komunikasi.edit');
        Route::post('/master/jalur_komunikasi/update/{id}', [JalurKomunikasiController::class, 'update'])->name('master.jalur-komunikasi.update');
        Route::delete('/master/jalur_komunikasi/destroy/{id}', [JalurKomunikasiController::class, 'destroy'])->name('master.jalur-komunikasi.destroy');

        // Data Bencana
        Route::get('/data/data_bencana', [DataBencanaController::class, 'index'])->name('data.data-bencana.index');
        Route::get('/data/data_bencana/create', [DataBencanaController::class, 'create'])->name('data.data-bencana.create');
        Route::post('/data/data_bencana/store', [DataBencanaController::class, 'store'])->name('data.data-bencana.store');
        Route::get('/data/data_bencana/edit/{id}', [DataBencanaController::class, 'edit'])->name('data.data-bencana.edit');
        Route::post('/data/data_bencana/update/{id}', [DataBencanaController::class, 'update'])->name('data.data-bencana.update');
        Route::delete('/data/data_bencana/destroy/{id}', [DataBencanaController::class, 'destroy'])->name('data.data-bencana.destroy');

        Route::get('/data/kejadian', [DataKejadianController::class, 'index'])->name('data.data-kejadian.index');
        Route::get('/data/kejadian/create', [DataKejadianController::class, 'create'])->name('data.data-kejadian.create');
        Route::post('/data/kejadian/store', [DataKejadianController::class, 'store'])->name('data.data-kejadian.store');
        Route::get('/data/kejadian/edit/{id}', [DataKejadianController::class, 'edit'])->name('data.data-kejadian.edit');
        Route::post('/data/kejadian/update/{id}', [DataKejadianController::class, 'update'])->name('data.data-kejadian.update');
        Route::delete('/data/kejadian/destroy/{id}', [DataKejadianController::class, 'destroy'])->name('data.data-kejadian.destroy');

        // Lokasi Pengungsian
        Route::get('/data/lokasi_pengungsian', [LokasiPengungsianController::class, 'index'])->name('data.lokasi-pengungsian.index');
        Route::get('/data/lokasi_pengungsian/create', [LokasiPengungsianController::class, 'create'])->name('data.lokasi-pengungsian.create');
        Route::post('/data/lokasi_pengungsian/store', [LokasiPengungsianController::class, 'store'])->name('data.lokasi-pengungsian.store');
        Route::get('/data/lokasi_pengungsian/edit/{id}', [LokasiPengungsianController::class, 'edit'])->name('data.lokasi-pengungsian.edit');
        Route::post('/data/lokasi_pengungsian/update/{id}', [LokasiPengungsianController::class, 'update'])->name('data.lokasi-pengungsian.update');
        Route::delete('/data/lokasi_pengungsian/destroy/{id}', [LokasiPengungsianController::class, 'destroy'])->name('data.lokasi-pengungsian.destroy');

        // Data Korban
        Route::get('/data/data_korban', [DataKorbanController::class, 'index'])->name('data.data-korban.index');
        Route::get('/data/data_korban/create', [DataKorbanController::class, 'create'])->name('data.data-korban.create');
        Route::post('/data/data_korban/store', [DataKorbanController::class, 'store'])->name('data.data-korban.store');
        Route::get('/data/data_korban/edit/{id}', [DataKorbanController::class, 'edit'])->name('data.data-korban.edit');
        Route::post('/data/data_korban/update/{id}', [DataKorbanController::class, 'update'])->name('data.data-korban.update');
        Route::delete('/data/data_korban/destroy/{id}', [DataKorbanController::class, 'destroy'])->name('data.data-korban.destroy');
        Route::post('/data/data_korban/getName', [DataKorbanController::class, 'getName'])->name('data.data-korban.getName');
        Route::post('/data/data_korban/getBirthdate', [DataKorbanController::class, 'getBirthdate'])->name('data.data-korban.getBirthdate');


        //Media Manager Routes
        Route::get('/showmanager', [MediaManagerController::class, 'showmanager'])->name('showmanager');
        Route::get('/mediamanager', [MediaManagerController::class, 'index'])->name('mediamanager');
        Route::post('/mediamanager/upload', [MediaManagerController::class, 'upload'])->name('mediaupload');
        Route::get('/mediamanager/images', [MediaManagerController::class, 'images'])->name('mediaimages');
        Route::get('/mediamanager/delete/', [MediaManagerController::class, 'delete'])->name('media.delete');

        Route::get('/settings', [SettingsController::class, 'settings'])->name('settings');

        // Daftar Indonesia
        Route::get('/provinces', [DependentDropdownController::class, 'provinces'])->name('provinces');
        Route::get('/cities', [DependentDropdownController::class, 'cities'])->name('cities');
        Route::get('/districts', [DependentDropdownController::class, 'districts'])->name('districts');
        Route::get('/villages', [DependentDropdownController::class, 'villages'])->name('villages');

        // Settings Routes

        Route::resource('user-profile', UserProfileController::class);

        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);

        Route::get('gallery', [GalleryController::class, 'index'])->name('gallery');
        Route::get('message', [MessageController::class, 'index'])->name('message');
        Route::delete('message/destroy/{id}', [MessageController::class, 'destroy'])->name('message.destroy');

        Route::get('documentation', [DocumentationController::class, 'index'])->name('documentation');
        Route::get('documentation/create', [DocumentationController::class, 'create'])->name('documentation.create');
        Route::post('documentation/store', [DocumentationController::class, 'store'])->name('documentation.store');
        Route::delete('documentation/destroy/{id}', [DocumentationController::class, 'destroy'])->name('documentation.destroy');
        Route::get('documentation/edit/{id}', [DocumentationController::class, 'edit'])->name('documentation.edit');
        Route::post('documentation/update/{id}', [DocumentationController::class, 'update'])->name('documentation.update');

        Route::get('/laporan-kejadian', [DataKejadianController::class, 'index'])->name('laporan-kejadian.index');
        Route::get('/laporan-kejadian/create', [DataKejadianController::class, 'create'])->name('laporan-kejadian.create');
        Route::post('/laporan-kejadian/store', [DataKejadianController::class, 'store'])->name('laporan-kejadian.store');
        Route::get('/laporan-kejadian/edit/{id}', [DataKejadianController::class, 'edit'])->name('laporan-kejadian.edit');
        Route::post('/laporan-kejadian/update/{id}', [DataKejadianController::class, 'update'])->name('laporan-kejadian.update');
        Route::delete('/laporan-kejadian/destroy/{id}', [DataKejadianController::class, 'destroy'])->name('laporan-kejadian.destroy');

        Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth:admin']], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });
    });


    Route::group(['middleware' => ['auth']], function () {

        /**
         * Verification Routes
         */
        Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware(['signed']);
        Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
    });

    // Login Routes

    Route::post('/logout', [UserLoginController::class, 'userLogout'])->name('user.logout');
    Route::get('/forgot', [ForgotPasswordController::class, 'forgot'])->name('user.forgot');
    Route::post('/forgot', [ForgotPasswordController::class, 'resetLink'])->name('user.forgot');
    Route::get('/password-reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('user.reset');
    Route::post('/password-reset', [ResetPasswordController::class, 'resetPassword'])->name('user.reset');
    Route::get('/email-subscribe/{token}', [HomePageController::class, 'news_letter_verify'])->name('news.letter.verify');
});
