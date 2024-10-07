<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Dashboard::index');
$routes->get('/login', 'Dashboard::login');
$routes->post('/login', 'Dashboard::login');
// ****************************register *******************************************
$routes->get('/register', 'Dashboard::registerView');
$routes->post('/register', 'Dashboard::register');
// ***********************dashboard **********************************************
$routes->get('/dashboard', 'Dashboard::dashboard');
$routes->post('/dashboard', 'Dashboard::dashboard');
// ****************************logout *********************************************
$routes->get('/logout', 'Dashboard::logout');

// *************************** testimonials ***************************************
$routes->get('/testimonials', 'TestimonialsController::index');
$routes->post('/saveDataAjax', 'TestimonialsController::saveDataAjax');
$routes->post('initialCall', 'TestimonialsController::initialCall');
$routes->get('initialCall', 'TestimonialsController::initialCall');
$routes->post('/updateDataAjax', 'TestimonialsController::updateDataAjax');
$routes->post('/deleteDataAjax', 'TestimonialsController::deleteDataAjax');


// *************************** Result ***************************************
$routes->get('/result', 'ResultController::index');
$routes->post('/saveStudDataAjax', 'ResultController::saveDataAjax');
$routes->post('/initialstudCall', 'ResultController::initialCall');
$routes->get('/initialstudCall', 'ResultController::initialCall');
$routes->post('/updateStudDataAjax', 'ResultController::updateDataAjax');
$routes->post('/deleteStudDataAjax', 'ResultController::deleteDataAjax');

// *************************** Gallery ***************************************
$routes->get('/gallery', 'GalleryController::index');
$routes->post('/saveGalDataAjax', 'GalleryController::saveDataAjax');
$routes->post('initialGalleryCall', 'GalleryController::initialCall');
$routes->get('initialGalleryCall', 'GalleryController::initialCall');
$routes->post('/updateGalleryDataAjax', 'GalleryController::updateDataAjax');
$routes->post('/deleteGalleryDataAjax', 'GalleryController::deleteDataAjax');
