<?php
use Illuminate\Support\Facades\Route;


/*
--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'SiteController@index')->name('homepage');
Route::get('/shows', 'SiteController@tvShows')->name('tvshows');
Route::get('/shows/{slug}', 'ShowController@tvShow')->name('tvshow');
Route::get('/shows/{slug}/episodes/{slug2}', 'ShowController@play')->name('episode');
Route::get('/people', 'PersonController@people')->name('people');
Route::get('/people/{slug}', 'PersonController@person')->name('person');
Route::get('sitemap.xml', 'SiteController@sitemap');
Route::get('/{slug}', 'PageController@index')->name('page');


$router->group(['prefix' => '/login'], function () use ($router) {
	$router->get('/',      ['as' => 'login', 'uses' => 'SiteController@index']);
}
);
