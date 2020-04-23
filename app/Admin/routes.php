<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->get('/api/batch', 'ApiController@batch');
    $router->get('/api/province', 'ApiController@province');
    $router->get('/api/school', 'ApiController@school');
    $router->get('/api/project', 'ApiController@project');
    $router->resource('projects', ProjectController::class);
    $router->resource('schools', SchoolController::class);
    $router->resource('provinces', ProvinceController::class);
    $router->resource('batches', BatchController::class);
    $router->resource('school-scorelines', SchoolScorelineController::class);
    $router->resource('collage-scorelines', CollageScorelineController::class);
    $router->resource('school-recommendations', SchoolRecommendationController::class);
});
