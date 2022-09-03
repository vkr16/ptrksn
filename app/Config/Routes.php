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
$routes->setDefaultController('Pages');
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
$routes->get('/', 'Auth::index');
$routes->get('/admin', 'Admin::index');
$routes->get('/user', 'User::index');


$routes->get('/admin/projects', 'Admin::index');
$routes->get('/admin/projects/detail', 'Admin::projectsDetail');
$routes->post('/admin/projects/add', 'Admin::projectsAdd');
$routes->post('/admin/projects/addComment', 'Admin::projectsAddComment');
$routes->post('/admin/projects/update', 'Admin::projectsUpdate');
$routes->post('/admin/projects/upload', 'Admin::projectsUpload');
$routes->post('/admin/projects/notes/upload', 'Admin::projectsNotesUpload');
$routes->get('/admin/projects/download', 'Admin::projectsDownload');
$routes->get('/admin/projects/delete', 'Admin::projectsDelete');
$routes->post('/admin/projects/comments/delete', 'Admin::commentsDelete');
$routes->post('/admin/projects/purge', 'Admin::projectPurge');
$routes->post('/admin/projects/addEvent', 'Admin::addEvent');
$routes->post('/admin/projects/editEvent', 'Admin::editEvent');
$routes->get('/admin/projects/event', 'Admin::projectsEvent');
$routes->post('/admin/projects/event/purge', 'Admin::eventPurge');
$routes->post('/admin/projects/eventdocs/upload', 'Admin::eventsUpload');
$routes->get('/admin/projects/events/delete', 'Admin::eventsDelete');
$routes->get('/admin/projects/events/download', 'Admin::eventsDownload');
$routes->get('/admin/projects/documents', 'Admin::projectDocuments');



$routes->get('/admin/meetings', 'Admin::meetings');
$routes->post('/admin/meetings/addMeeting', 'Admin::meetingsAdd');
$routes->post('/admin/meetings/editMeeting', 'Admin::meetingsEdit');
$routes->post('/admin/meetings/delete', 'Admin::meetingsDelete');
$routes->get('/admin/meetings/attendance', 'Admin::meetingsAttendance');
$routes->get('/admin/meetings/attendance/topdf', 'Admin::meetingsAttendance2pdf');
$routes->get('/admin/meetings/attendance/toxlsx', 'Admin::meetingsAttendance2xlsx');
$routes->get('/admin/meetings/attendance/openaccess', 'Admin::meetingsAttopen');
$routes->get('/admin/meetings/attendance/closeaccess', 'Admin::meetingsAttclose');

$routes->get('/user/meetings', 'User::meetings');
$routes->get('/user/meetings/attendance', 'User::meetingsAttendance');
$routes->post('/user/meetings/attendance/sign', 'User::meetingsSign');
$routes->post('/user/meetings/attendance/void', 'User::meetingsVoid');




$routes->get('/admin/users', 'Admin::users');
$routes->post('/admin/users/add', 'Admin::usersAdd');
$routes->post('/admin/users/getUserData', 'Admin::usersGet');
$routes->post('/admin/users/update', 'Admin::usersUpdate');
$routes->post('/admin/users/resetPassword', 'Admin::usersResetPassword');
$routes->post('/admin/users/delete', 'Admin::usersDelete');




$routes->get('/user/projects', 'User::index');
$routes->get('/user/projects/detail', 'User::projectsDetail');
$routes->post('/user/projects/addComment', 'User::projectsAddComment');
$routes->post('/user/projects/upload', 'User::projectsUpload');
$routes->get('/user/projects/download', 'User::projectsDownload');
$routes->get('/user/projects/event', 'User::projectsEvent');



$routes->get('/login', 'Auth::index');
$routes->get('/logout', 'Auth::logout');
$routes->post('/login', 'Auth::login');

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
