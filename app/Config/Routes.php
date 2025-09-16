<?php

use CodeIgniter\Router\RouteCollection;

// TODO:
// Deployment
// Tambah CRUD Departemen
// Tambah CRUD Keahlian

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'DashboardController::index');

$routes->get('pegawai/export/csv', 'PegawaiController::exportCsv'); // export data pegawai
$routes->resource('pegawai', ['controller' => 'PegawaiController']);

$routes->get('laporan', 'LaporanController::index');

