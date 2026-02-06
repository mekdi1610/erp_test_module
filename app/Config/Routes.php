<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('admin/dashboard', 'Admin::dashboard');
$routes->get('beneficiaries', 'Beneficiary::index');
$routes->get('beneficiaries/create', 'Beneficiary::create');
$routes->post('beneficiaries/store', 'Beneficiary::store');
$routes->get('beneficiaries/edit/(:num)', 'Beneficiary::edit/$1');
$routes->post('beneficiaries/update/(:num)', 'Beneficiary::update/$1');
$routes->get('beneficiaries/delete/(:num)', 'Beneficiary::delete/$1');
$routes->get('projects', 'Project::index');
$routes->get('projects/create', 'Project::create');
$routes->post('projects/store', 'Project::store');
$routes->get('projects/edit/(:num)', 'Project::edit/$1');
$routes->post('projects/update/(:num)', 'Project::update/$1');
$routes->get('projects/delete/(:num)', 'Project::delete/$1');
$routes->get('interventions', 'Intervention::index');
$routes->get('interventions/create', 'Intervention::create');
$routes->post('interventions/store', 'Intervention::store');
$routes->get('interventions/edit/(:num)', 'Intervention::edit/$1');
$routes->post('interventions/update/(:num)', 'Intervention::update/$1');
$routes->get('interventions/delete/(:num)', 'Intervention::delete/$1');
$routes->get('attendance', 'Attendance::index');
$routes->get('attendance/events/create', 'Attendance::createEvent');
$routes->post('attendance/events/store', 'Attendance::storeEvent');
$routes->get('attendance/events/edit/(:num)', 'Attendance::editEvent/$1');
$routes->post('attendance/events/update/(:num)', 'Attendance::updateEvent/$1');
$routes->get('attendance/events/delete/(:num)', 'Attendance::deleteEvent/$1');
$routes->get('attendance/record/(:num)', 'Attendance::record/$1');
$routes->post('attendance/record/(:num)', 'Attendance::storeRecord/$1');
$routes->get('case-management/(:num)', 'CaseManagement::show/$1');
$routes->post('case-management/(:num)/progress', 'CaseManagement::storeProgress/$1');
$routes->post('case-management/(:num)/case-note', 'CaseManagement::storeCaseNote/$1');
$routes->post('case-management/(:num)/referral', 'CaseManagement::storeReferral/$1');
$routes->post('case-management/(:num)/enrollment', 'CaseManagement::storeEnrollment/$1');
$routes->get('case-management/progress/delete/(:num)', 'CaseManagement::deleteProgress/$1');
$routes->get('case-management/case-note/delete/(:num)', 'CaseManagement::deleteCaseNote/$1');
$routes->get('case-management/referral/delete/(:num)', 'CaseManagement::deleteReferral/$1');
$routes->get('case-management/enrollment/delete/(:num)', 'CaseManagement::deleteEnrollment/$1');
$routes->get('alerts', 'Alerts::index');
