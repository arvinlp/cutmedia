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

$router->get('/', function() use ($router){
        return response()->json([
            'message'   => 'جهت دسترسی به وب سرویس ابتدا وارد شوید.',
            'code'      => (int) 200,
        ], 200);
});

$router->group(['prefix' => '/city'], function () use ($router) {
    $router->get('/',   ['as'=>'Proviences List',   'uses'=>'CityController@provinces']);
    $router->get('/{province:[0-9]+}', ['as'=>'Counties List', 'uses'=>'CityController@counties']);
    $router->get('/{province:[0-9]+}/{county:[0-9]+}', ['as'=>'Cites List',    'uses'=>'CityController@cities']);
    $router->get('/{province:[0-9]+}/{county:[0-9]+}/{city:[0-9]+}',   ['as'=>'City',    'uses'=>'CityController@city']);
});

$router->group(['prefix' => '/tv','namespace' => 'TV'], function () use ($router) {
    $router->get('/',           ['as'=>'List TV Show',      'uses'=>'SerieController@getAllSeries']);
    $router->get('/all',        ['as'=>'List TV Show',      'uses'=>'SerieController@getAllSeriesWithEpisodes']);
    $router->get('/homepage',   ['as'=>'List TV Show',      'uses'=>'SerieController@index']);
    $router->get('/lastes',     ['as'=>'Last TV Show',      'uses'=>'SerieController@getLastSeries']);
    $router->get('/special',    ['as'=>'Special TV Show',   'uses'=>'SerieController@getSpecialSeries']);
    $router->get('/show/{show:[0-9]+}', ['as'=>'Show', 'uses'=>'SerieController@getSerie']);
    $router->get('/show/{show:[0-9]+}/episodes', ['as'=>'Show Episodes List', 'uses'=>'SerieController@getSerieEpisodes']);
    $router->get('/show/{show:[0-9]+}/episodes/{id:[0-9]+}', ['as'=>'Episode', 'uses'=>'SerieController@getEpisode']);
});
$router->group(['prefix' => ''], function () use ($router) {
    $router->get('/ads',    ['as'=>'ads',       'uses'=>'HomeController@getAds']);
    $router->get('/slides', ['as'=>'slider',    'uses'=>'HomeController@getSlider']);
    $router->get('/series', ['as'=>'slider',    'uses'=>'HomeController@getSeries']);
});