<?php
namespace Config;
// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
    //metodo get,post     //ruta que colo el usuaro     //contralador   // metodo
$routes->get('/', 'Home::index');
$routes->get('/prueba', 'Home::prueba');
$routes->get('/prueba2', 'Prueba::index');
// ' nombre que sea'       'nombre ctrl' :: 'nombre del metodo'


//ruta nueva





$routes->get('/ExcelLector', 'ExcelLector::index');
$routes->post('/recibe', 'ExcelLector::recibe');

$routes->get('/recibe', 'ExcelLector::recibe');

$routes->post('/exportar', 'ExcelLector::exportar');
$routes->post('/Login/aut', 'Login::AutoLogin');
$routes->post('/Login/process', 'Login::ProccesAuto');
$routes->get('/alta', 'Alta::index');
$routes->post('/alta/create', 'Alta::create');
$routes->get('/alta/read', 'Alta::read');

$routes->get('/genera', 'Genera::index');
$routes->get('/gafete', 'Qr::gafete');
$routes->get('/gafetes', 'Qr::gafetes');


$routes->get('/qr', 'Qr::index');
$routes->post('/desactivar', 'Qr::desactivar');
$routes->post('/createall', 'Qr::createAll');
$routes->post('/create', 'Qr::create');
$routes->post('/verify', 'Qr::recupera');
$routes->post('/scanner', 'Qr::scanner');
$routes->post('/auth', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/admin', 'admin::index');

$routes->get('/aforo', 'admin::aforo');
$routes->get('/movimientos', 'admin::movimientos');
$routes->get('/resumen', 'admin::resumen');
//string como queremosingresa     controlador::metodo
$routes->get('/imagen', 'Imagen::index');















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
