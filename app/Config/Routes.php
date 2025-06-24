<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

$routes->get('/user/login', 'User\AuthController::login');
$routes->post('/user/login', 'User\AuthController::login');

// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/book', 'Home::book');
$routes->group('admin/loans', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('export/excel', 'LoanController::exportExcel');
    $routes->get('export/pdf', 'LoanController::exportPdf');
    $routes->get('print', 'LoanController::print');
});
$routes->get('users', '\App\Controllers\User\UserController::index');
$routes->group('users', ['namespace' => 'App\Controllers\Users'], function($routes) {
    $routes->get('/', 'UsersController::index');
    $routes->get('edit/(:num)', 'UsersController::edit/$1');
    $routes->post('update/(:num)', 'UsersController::update/$1');
    $routes->delete('delete/(:num)', 'UsersController::delete/$1');
$routes->get('/users', 'Users\UsersController::index');
$routes->get('/Auth/login', 'Members\AuthController::login');
$routes->post('admin/fines/save-scan', 'Admin\FinesController::saveScan');

$routes->get('admin/returns/new/search', 'Loans\ReturnsController::searchLoan');
$routes->get('admin/members/exportpdf', 'Admin\MembersController::exportPdf');


// Untuk menambah admin (form register)
$routes->get('/admin/users/create', 'Users\RegisterController::create');
$routes->post('/admin/users/create', 'Users\RegisterController::store');
// Menampilkan daftar admin
$routes->get('/users', 'Users\UsersController::index');

// Form edit admin (dari button edit di index)
$routes->get('/admin/users/edit/(:num)', 'Users\UsersController::edit/$1');
$routes->post('/admin/users/edit/(:num)', 'Users\UsersController::update/$1');

// Hapus admin
$routes->get('/admin/users/delete/(:num)', 'Users\UsersController::delete/$1');
$routes->delete('admin/members/(:segment)', 'Members\MembersController::delete/$1');


// Form tambah admin (kalau kamu pakai RegisterController untuk tambah)
$routes->get('/admin/users/create', 'Users\RegisterController::create');
$routes->post('/admin/users/create', 'Users\RegisterController::store');
$routes->delete('admin/members/(:segment)', 'Members\MembersController::delete/$1');
$routes->get('admin/members/(:segment)/edit', 'Members\MembersController::edit/$1');


$routes->get('/members/login', 'Members\AuthController::login');
$routes->post('/members/login', 'Members\AuthController::login');
$routes->get('/members/register', 'Members\AuthController::register');
$routes->post('/members/register', 'Members\AuthController::register');
$routes->get('/members/logout', 'Members\AuthController::logout');

// Setelah login berhasil
$routes->get('/members/dashboard', function () {
    if (!session()->get('is_logged_in')) {
        return redirect()->to('/members/login');
    }
    echo "<h2>Halo, " . session('member_name') . " 👋</h2><a href='/members/logout'>Logout</a>";
});


});



service('auth')->routes($routes);

$routes->group('admin', ['filter' => 'session'], static function (RouteCollection $routes) {
    $routes->get('/', 'Dashboard\DashboardController');
    $routes->get('dashboard', 'Dashboard\DashboardController::dashboard');

    $routes->resource('members', ['controller' => 'Members\MembersController']);
    $routes->resource('books', ['controller' => 'Books\BooksController']);
    $routes->resource('categories', ['controller' => 'Books\CategoriesController']);
    $routes->resource('racks', ['controller' => 'Books\RacksController']);

    $routes->get('loans/new/members/search', 'Loans\LoansController::searchMember');
    $routes->get('loans/new/books/search', 'Loans\LoansController::searchBook');
    $routes->post('loans/new', 'Loans\LoansController::new');
    $routes->resource('loans', ['controller' => 'Loans\LoansController']);
    

    $routes->get('returns/new/search', 'Loans\ReturnsController::searchLoan');
    $routes->resource('returns', ['controller' => 'Loans\ReturnsController']);

    $routes->get('fines/returns/search', 'Loans\FinesController::searchReturn');
    $routes->get('fines/pay/(:any)', 'Loans\FinesController::pay/$1');
    $routes->resource('fines/settings', ['controller' => 'Loans\FineSettingsController', 'filter' => 'group:superadmin']);
    $routes->resource('fines', ['controller' => 'Loans\FinesController']);

    $routes->group('users', ['filter' => 'group:superadmin'], static function (RouteCollection $routes) {
        $routes->get('new', 'Users\RegisterController::index');
        $routes->post('', 'Users\RegisterController::registerAction');
    });
    $routes->resource('users', ['controller' => 'Users\UsersController', 'filter' => 'group:superadmin']);
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
