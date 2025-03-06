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
$routes->resource("kehadiran");
