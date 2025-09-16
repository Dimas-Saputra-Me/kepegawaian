<?php

use CodeIgniter\Router\RouteCollection;

// TODO:
// Deployment

// Tambah CRUD Departemen
// Tambah CRUD Keahlian

// FIXME:
// validation on departemenid and keahlian to make sure it exists on table
// keahlian field pegawai create/edit (form)

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'DashboardController::index');

$routes->get('pegawai/export/csv', 'PegawaiController::exportCsv'); // export data pegawai
$routes->resource('pegawai', ['controller' => 'PegawaiController']);

$routes->get('laporan', 'LaporanController::index');

