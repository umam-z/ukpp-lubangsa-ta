<?php

use UmamZ\UkppLubangsa\App\Router;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Controller\HomeController;
use UmamZ\UkppLubangsa\Controller\LaporanController;
use UmamZ\UkppLubangsa\Controller\ObatController;
use UmamZ\UkppLubangsa\Controller\PasienController;
use UmamZ\UkppLubangsa\Controller\PemeriksaanController;
use UmamZ\UkppLubangsa\Controller\PemeriksaanObatController;
use UmamZ\UkppLubangsa\Controller\PendidikanController;
use UmamZ\UkppLubangsa\Controller\PetugasController;
use UmamZ\UkppLubangsa\Controller\UserController;
use UmamZ\UkppLubangsa\Middleware\MustLoginMiddleware;
use UmamZ\UkppLubangsa\Middleware\MustNotLoginMiddleware;

require_once __DIR__ . "/../vendor/autoload.php";

// database production
Database::getConnection('prod');

# Home Controller
Router::add('GET', '/', HomeController::class, 'index', []);

# User Controller
Router::add('GET', '/users/login', UserController::class, 'login', [MustNotLoginMiddleware::class]);
Router::add('POST', '/users/login', UserController::class, 'postLogin', [MustNotLoginMiddleware::class]);
Router::add('GET', '/users/register', UserController::class, 'register', [MustNotLoginMiddleware::class]);
Router::add('POST', '/users/register', UserController::class, 'postRegister', [MustNotLoginMiddleware::class]);
Router::add('GET', '/users/logout', UserController::class, 'logout', [MustLoginMiddleware::class]);

# Petugas Controller
Router::add("GET", '/petugas', PetugasController::class, 'petugas', [MustLoginMiddleware::class]);
Router::add("POST", '/petugas', PetugasController::class, 'create', [MustLoginMiddleware::class]);
Router::add("POST", '/petugas/([0-9]*)/delete', PetugasController::class, 'delete', [MustLoginMiddleware::class]);

# Obat Controller
Router::add('GET', '/obat', ObatController::class, 'obat', [MustLoginMiddleware::class]);
Router::add('POST', '/obat', ObatController::class, 'create', [MustLoginMiddleware::class]);
Router::add('POST', '/obat/([0-9]*)/delete', ObatController::class, 'delete', [MustLoginMiddleware::class]);
Router::add('GET', '/obat/([0-9]*)/stock', ObatController::class, 'updateStock', [MustLoginMiddleware::class]);
Router::add('POST', '/obat/([0-9]*)/stock', ObatController::class, 'postUpdateStock', [MustLoginMiddleware::class]);

# Pendidikan Controller
Router::add('GET', '/pendidikan', PendidikanController::class, 'pendidikan', [MustLoginMiddleware::class]);
Router::add('POST', '/pendidikan', PendidikanController::class, 'create', [MustLoginMiddleware::class]);
Router::add('POST', '/pendidikan/([0-9]*)/delete', PendidikanController::class, 'delete', [MustLoginMiddleware::class]);

# Pasien Controller
Router::add('GET', '/pasien', PasienController::class, 'pasien', [MustLoginMiddleware::class]);
Router::add('POST', '/pasien', PasienController::class, 'create', [MustLoginMiddleware::class]);
Router::add('POST', '/pasien/([0-9]*)/delete', PasienController::class, 'delete', [MustLoginMiddleware::class]);
Router::add('POST', '/pasien/([0-9]*)/surat', PasienController::class, 'surat', [MustLoginMiddleware::class]);


# Pemeriksaan Controller
Router::add('GET', '/pasien/([0-9]*)/periksa', PemeriksaanController::class, 'pemeriksaan', [MustLoginMiddleware::class]);
Router::add('POST', '/pasien/([0-9]*)/periksa', PemeriksaanController::class, 'create', [MustLoginMiddleware::class]);
Router::add('POST', '/pasien/([0-9]*)/periksa/([0-9]*)/delete', PemeriksaanController::class, 'delete', [MustLoginMiddleware::class]);

# PemeriksaanObat Controller
Router::add('GET', '/periksa/([0-9]*)/obat', PemeriksaanObatController::class, 'pemeriksaanObat', [MustLoginMiddleware::class]);
Router::add('POST', '/periksa/([0-9]*)/delete', PemeriksaanObatController::class, 'delete', [MustLoginMiddleware::class]);
Router::add('POST', '/periksa/([0-9]*)/obat/([0-9]*)/pasien', PemeriksaanObatController::class, 'addPemeriksaanObat', [MustLoginMiddleware::class]);
Router::add('POST', '/periksa/([0-9]*)/obat/([0-9]*)/delete', PemeriksaanObatController::class, 'delete', [MustLoginMiddleware::class]);

# Laporan Controller
Router::add('GET', '/laporan', LaporanController::class, 'laporan',[MustLoginMiddleware::class]);

Router::run();