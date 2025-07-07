<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\JobVacancyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ===================
// RUTE PUBLIK
// ===================

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register/alumni', [AuthController::class, 'showAlumniRegistrationForm'])->name('register.alumni');
Route::post('/register/alumni', [AuthController::class, 'registerAlumni']);

Route::get('/register/guru', [AuthController::class, 'showGuruRegistrationForm'])->name('register.guru');
Route::post('/register/guru', [AuthController::class, 'registerGuru']);

// ===================
// RUTE DENGAN LOGIN
// ===================

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // ===================
    // RUTE ADMIN
    // ===================
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::prefix('alumni')->name('alumni.')->group(function () {
            Route::get('/', [AdminController::class, 'alumniIndex'])->name('index');
            Route::get('/create', [AdminController::class, 'alumniCreate'])->name('create');
            Route::post('/', [AdminController::class, 'alumniStore'])->name('store');
            Route::get('/{alumni}', [AdminController::class, 'alumniShow'])->name('show');
            Route::get('/{alumni}/edit', [AdminController::class, 'alumniEdit'])->name('edit');
            Route::put('/{alumni}', [AdminController::class, 'alumniUpdate'])->name('update');
            Route::delete('/{alumni}', [AdminController::class, 'alumniDestroy'])->name('destroy');
            Route::get('/export/{type}', [AdminController::class, 'exportAlumni'])->name('export');
            Route::get('/print/{id?}', [AdminController::class, 'printAlumni'])->name('print');
            Route::get('/export', [AdminController::class, 'exportAlumni'])->name('export');

        });

        Route::prefix('guru')->name('guru.')->group(function () {
            Route::get('/', [AdminController::class, 'guruIndex'])->name('index');
            Route::get('/create', [AdminController::class, 'guruCreate'])->name('create');
            Route::post('/', [AdminController::class, 'guruStore'])->name('store');
            Route::get('/{teacher}', [AdminController::class, 'guruShow'])->name('show');
            Route::get('/{teacher}/edit', [AdminController::class, 'guruEdit'])->name('edit');
            Route::put('/{teacher}', [AdminController::class, 'guruUpdate'])->name('update');
            Route::delete('/{teacher}', [AdminController::class, 'guruDestroy'])->name('destroy');
        });

            // Routes untuk Rekapitulasi Alumni (Admin)
        Route::prefix('rekapitulasi')->name('rekapitulasi.')->group(function () {
            Route::get('/', [AdminController::class, 'rekapitulasiIndex'])->name('index');
            Route::get('/tahun/{year}', [AdminController::class, 'rekapitulasiDetail'])->name('detail');
            Route::get('/tahun/{year}/print', [AdminController::class, 'rekapitulasiPrint'])->name('print');
        });

        Route::resource('sliders', SliderController::class);
        Route::resource('job-vacancies', JobVacancyController::class);

        Route::get('/statistics', [AdminController::class, 'showStatistics'])->name('statistics');
        Route::get('/statistics/export/{type}', [AdminController::class, 'exportStatistics'])->name('statistics.export');
        Route::get('/statistics/print', [AdminController::class, 'printStatistics'])->name('statistics.print');

        Route::get('/profile', [AdminController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    });

    // ===================
    // RUTE ALUMNI
    // ===================
    Route::middleware(['alumni'])->prefix('alumni')->name('alumni.')->group(function () {

        Route::get('/dashboard', [AlumniController::class, 'index'])->name('dashboard');
        Route::get('/profile', [AlumniController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [AlumniController::class, 'updateProfile'])->name('profile.update');

        Route::get('/news', [NewsController::class, 'indexAlumni'])->name('news.index');
        Route::get('/news/{news}', [NewsController::class, 'showAlumni'])->name('news.show');

        Route::get('/search', [AlumniController::class, 'searchAlumni'])->name('search');
        Route::get('/view/{alumni}', [AlumniController::class, 'viewAlumniDetail'])->name('view.detail');
    });

    // ===================
    // RUTE GURU
    // ===================
    Route::middleware(['guru'])->prefix('guru')->name('guru.')->group(function () {

        Route::get('/dashboard', [GuruController::class, 'index'])->name('dashboard');

        Route::prefix('alumni')->name('alumni.')->group(function () {
            Route::get('/', [GuruController::class, 'listAlumni'])->name('index');
            Route::get('/{alumni}', [GuruController::class, 'showAlumni'])->name('show');
            Route::get('/export/{type}', [GuruController::class, 'exportAlumni'])->name('export');
            Route::get('/print/{id?}', [GuruController::class, 'printAlumni'])->name('print');
        });

        Route::get('/statistics', [GuruController::class, 'showStatistics'])->name('statistics');
        Route::get('/statistics/export/{type}', [GuruController::class, 'exportStatistics'])->name('statistics.export');
        Route::get('/statistics/print', [GuruController::class, 'printStatistics'])->name('statistics.print');

        Route::get('/profile', [GuruController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [GuruController::class, 'updateProfile'])->name('profile.update');

                // Routes untuk Rekapitulasi Alumni (Guru)
        Route::prefix('rekapitulasi')->name('rekapitulasi.')->group(function () {
            Route::get('/', [GuruController::class, 'rekapitulasiIndex'])->name('index');
            Route::get('/tahun/{year}', [GuruController::class, 'rekapitulasiDetail'])->name('detail');
            Route::get('/tahun/{year}/print', [GuruController::class, 'rekapitulasiPrint'])->name('print');
        });
    });

    // ===================
    // RUTE BERITA (admin atau guru)
    // ===================
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/{news}', [NewsController::class, 'show'])
            ->where('news', '[0-9]+')
            ->name('show');

        Route::middleware(['admin_or_guru'])->group(function () {
            Route::get('/create', [NewsController::class, 'create'])->name('create');
            Route::post('/', [NewsController::class, 'store'])->name('store');
            Route::get('/{news}/edit', [NewsController::class, 'edit'])->name('edit');
            Route::put('/{news}', [NewsController::class, 'update'])->name('update');
            Route::delete('/{news}', [NewsController::class, 'destroy'])->name('destroy');
        });
    });

    // ===================
    // RUTE LOWONGAN
    // ===================
    Route::get('/job-vacancies', [JobVacancyController::class, 'indexPublic'])->name('job_vacancies.index');
    Route::get('/job-vacancies/{jobVacancy}', [JobVacancyController::class, 'showPublic'])->name('job_vacancies.show');
});
