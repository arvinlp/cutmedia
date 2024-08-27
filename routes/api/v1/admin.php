<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


$router->get('/', function() use ($router){
    return $router->getRoutes();
});

// Profile
$router->group(['prefix' => '/profile'], function () use ($router) {
    $router->get('/',       ['as'=>'Get User Profile',      'uses'=>'Portal\AdminController@getProfile']);
    $router->post('/',      ['as'=>'Update User Profile',   'uses'=>'Portal\AdminController@updateProfile']);
});

// User
$router->group(['prefix' => '/staffs'], function () use ($router) {
	$router->get('/',               [ 'as'=>'Users List',		'uses'=>'Portal\AdminController@index']);
	$router->get('/list',           [ 'as'=>'Users List',		'uses'=>'Portal\AdminController@list']);
	$router->post('/new',           [ 'as'=>'Add New User',		'uses'=>'Portal\AdminController@addOrUpdate']);
	$router->get('/{id:[0-9]+}',	[ 'as'=>'Get User Data',    'uses'=>'Portal\AdminController@get']);
	$router->post('/{id:[0-9]+}',	[ 'as'=>'Update User Data', 'uses'=>'Portal\AdminController@addOrUpdate']);
	$router->delete('/{id:[0-9]+}',	[ 'as'=>'Delete User Data', 'uses'=>'Portal\AdminController@delete']);
});

// User
$router->group(['prefix' => '/users'], function () use ($router) {
	$router->get('/',               [ 'as'=>'Users List',		'uses'=>'Portal\UserController@index']);
	$router->get('/list',           [ 'as'=>'Users List',		'uses'=>'Portal\UserController@list']);
	$router->post('/new',           [ 'as'=>'Add New User',		'uses'=>'Portal\UserController@addOrUpdate']);
	$router->get('/{id:[0-9]+}',	[ 'as'=>'Get User Data',    'uses'=>'Portal\UserController@get']);
	$router->post('/{id:[0-9]+}',	[ 'as'=>'Update User Data', 'uses'=>'Portal\UserController@addOrUpdate']);
	$router->delete('/{id:[0-9]+}',	[ 'as'=>'Delete User Data', 'uses'=>'Portal\UserController@delete']);
});

// Package
$router->group(['prefix' => '/packages'], function () use ($router) {
	$router->get('/',               [ 'as'=>'Packages List',		'uses'=>'Portal\PackageController@index']);
	$router->get('/list',           [ 'as'=>'Packages List',		'uses'=>'Portal\PackageController@list']);
	$router->post('/new',           [ 'as'=>'Add New Package',		'uses'=>'Portal\PackageController@addOrUpdate']);
	$router->get('/{id:[0-9]+}',	[ 'as'=>'Get Package Data',		'uses'=>'Portal\PackageController@get']);
	$router->post('/{id:[0-9]+}',	[ 'as'=>'Update Package Data',	'uses'=>'Portal\PackageController@addOrUpdate']);
	$router->delete('/{id:[0-9]+}',	[ 'as'=>'Delete Package Data',	'uses'=>'Portal\PackageController@delete']);
});

// Notification
$router->group(['prefix' => '/notifications'], function () use ($router) {
	$router->get('/',               [ 'as'=>'Notifications List',		'uses'=>'Portal\NotificationController@index']);
	$router->get('/list',           [ 'as'=>'Notifications List',		'uses'=>'Portal\NotificationController@list']);
	$router->post('/new',           [ 'as'=>'Add New Notification',		'uses'=>'Portal\NotificationController@addOrUpdate']);
	$router->get('/{id:[0-9]+}',	[ 'as'=>'Get Notification Data',	'uses'=>'Portal\NotificationController@get']);
	$router->post('/{id:[0-9]+}',	[ 'as'=>'Update Notification Data',	'uses'=>'Portal\NotificationController@addOrUpdate']);
	$router->delete('/{id:[0-9]+}',	[ 'as'=>'Delete Notification Data',	'uses'=>'Portal\NotificationController@delete']);
});

// ads
$router->group(['prefix' => '/ads'], function () use ($router) {
	$router->get('/',               [ 'as'=>'ADS List',		'uses'=>'Portal\ADSController@index']);
	$router->get('/list',           [ 'as'=>'ADS List',		'uses'=>'Portal\ADSController@list']);
	$router->post('/new',           [ 'as'=>'Add New ADS',	'uses'=>'Portal\ADSController@addOrUpdate']);
	$router->get('/{id:[0-9]+}',	[ 'as'=>'Get ADS Data',	'uses'=>'Portal\ADSController@get']);
	$router->post('/{id:[0-9]+}',	[ 'as'=>'Update ADS Data',	'uses'=>'Portal\ADSController@addOrUpdate']);
	$router->delete('/{id:[0-9]+}',	[ 'as'=>'Delete ADS Data',	'uses'=>'Portal\ADSController@delete']);
	$router->post('/{id:[0-9]+}/status',	[ 'as'=>'Update ADS Status',	'uses'=>'Portal\ADSController@updateStatus']);
});

// Category
$router->group(['prefix' => '/categories'], function () use ($router) {
	$router->get('/',               [ 'as'=>'Categories List',		'uses'=>'Portal\CategoryController@index']);
	$router->get('/list',           [ 'as'=>'Categories List',		'uses'=>'Portal\CategoryController@list']);
	$router->get('/list/{id:[0-9]+}',	[ 'as'=>'Categories List',		'uses'=>'Portal\CategoryController@list']);
	$router->post('/new',           [ 'as'=>'Add New Category',		'uses'=>'Portal\CategoryController@addOrUpdate']);
	$router->get('/{id:[0-9]+}',	[ 'as'=>'Get Category Data',    'uses'=>'Portal\CategoryController@get']);
	$router->post('/{id:[0-9]+}',	[ 'as'=>'Update Category Data', 'uses'=>'Portal\CategoryController@addOrUpdate']);
	$router->delete('/{id:[0-9]+}',	[ 'as'=>'Delete Category Data', 'uses'=>'Portal\CategoryController@delete']);
});

// ProductType
$router->group(['prefix' => '/product-types'], function () use ($router) {
	$router->get('/',               [ 'as'=>'ProductTypes List',		'uses'=>'Portal\ProductTypeController@index']);
	$router->get('/list',           [ 'as'=>'ProductTypes List',		'uses'=>'Portal\ProductTypeController@list']);
	$router->post('/new',           [ 'as'=>'Add New ProductType',		'uses'=>'Portal\ProductTypeController@addOrUpdate']);
	$router->get('/{id:[0-9]+}',	[ 'as'=>'Get ProductType Data',		'uses'=>'Portal\ProductTypeController@get']);
	$router->post('/{id:[0-9]+}',	[ 'as'=>'Update ProductType Data',	'uses'=>'Portal\ProductTypeController@addOrUpdate']);
	$router->delete('/{id:[0-9]+}',	[ 'as'=>'Delete ProductType Data',	'uses'=>'Portal\ProductTypeController@delete']);
});

// ProductSize
$router->group(['prefix' => '/product-size'], function () use ($router) {
	$router->get('/',               [ 'as'=>'ProductSizes List',		'uses'=>'Portal\ProductSizeController@index']);
	$router->get('/list',           [ 'as'=>'ProductSizes List',		'uses'=>'Portal\ProductSizeController@list']);
	$router->get('/list/{id:[0-9]+}',	[ 'as'=>'ProductSizes List',	'uses'=>'Portal\ProductSizeController@list']);
	$router->post('/new',           [ 'as'=>'Add New ProductSize',		'uses'=>'Portal\ProductSizeController@addOrUpdate']);
	$router->get('/{id:[0-9]+}',	[ 'as'=>'Get ProductSize Data',		'uses'=>'Portal\ProductSizeController@get']);
	$router->post('/{id:[0-9]+}',	[ 'as'=>'Update ProductSize Data',	'uses'=>'Portal\ProductSizeController@addOrUpdate']);
	$router->delete('/{id:[0-9]+}',	[ 'as'=>'Delete ProductSize Data',	'uses'=>'Portal\ProductSizeController@delete']);
});

// ProductGrade
$router->group(['prefix' => '/product-grades'], function () use ($router) {
	$router->get('/',               [ 'as'=>'ProductGrades List',		'uses'=>'Portal\ProductGradeController@index']);
	$router->get('/list',           [ 'as'=>'ProductGrades List',		'uses'=>'Portal\ProductGradeController@list']);
	$router->get('/list/{id:[0-9]+}',	[ 'as'=>'ProductGrades List',	'uses'=>'Portal\ProductGradeController@list']);
	$router->post('/new',           [ 'as'=>'Add New ProductGrade',		'uses'=>'Portal\ProductGradeController@addOrUpdate']);
	$router->get('/{id:[0-9]+}',	[ 'as'=>'Get ProductGrade Data',	'uses'=>'Portal\ProductGradeController@get']);
	$router->post('/{id:[0-9]+}',	[ 'as'=>'Update ProductGrade Data',	'uses'=>'Portal\ProductGradeController@addOrUpdate']);
	$router->delete('/{id:[0-9]+}',	[ 'as'=>'Delete ProductGrade Data',	'uses'=>'Portal\ProductGradeController@delete']);
});
