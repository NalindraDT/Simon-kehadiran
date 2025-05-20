<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->resource("mahasiswa");
$routes->resource("kelas");
$routes->resource("user");
$routes->resource("dosen");
$routes->resource("matkul");
// $routes->post('login', 'Auth::login');
// $routes->get('kelas', 'Kelas::index', ['filter' => 'auth']); // Contoh proteksi
$routes->get('kehadiran1/cetak', 'Kehadiran1::cetak');
$routes->get('kehadiran1/npm/(:segment)', 'Kehadiran1::byNpm/$1');


// $routes->get('kehadiran1/username/(:segment)', 'Kehadiran1::byUsername/$1');
$routes->resource("kehadiran1");