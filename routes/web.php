<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// Home page
$app->get('/', function () use ($app) {
    return $app->version();
});

// Posts
$app->get('/posts','PostController@index');
$app->post('/posts','PostController@store');
$app->get('/posts/{post_id}','PostController@show');
$app->put('/posts/{post_id}', 'PostController@update');
$app->patch('/posts/{post_id}', 'PostController@update');
$app->delete('/posts/{post_id}', 'PostController@destroy');

// Users
$app->get('/users/', 'UserController@index');
$app->post('/users/', 'UserController@store');
$app->get('/users/{user_id}', 'UserController@show');
$app->put('/users/{user_id}', 'UserController@update');
$app->patch('/users/{user_id}', 'UserController@update');
$app->delete('/users/{user_id}', 'UserController@destroy');

// Comments
$app->get('/comments', 'CommentController@index');
$app->get('/comments/{comment_id}', 'CommentController@show');

// Comment(s) of a post
$app->get('/posts/{post_id}/comments', 'PostCommentController@index');
$app->post('/posts/{post_id}/comments', 'PostCommentController@store');
$app->put('/posts/{post_id}/comments/{comment_id}', 'PostCommentController@update');
$app->patch('/posts/{post_id}/comments/{comment_id}', 'PostCommentController@update');
$app->delete('/posts/{post_id}/comments/{comment_id}', 'PostCommentController@destroy');

// Stores
$app->get('/stores', 'StoreController@index');
$app->get('/stores/{storeId}', 'StoreController@show');
$app->post('/stores', 'StoreController@save');
$app->put('/stores/{storeId}', 'StoreController@edit');
$app->delete('/stores/{storeId}', 'StoreController@destroy');

// Brands
$app->get('/brands', 'BrandController@index');
$app->get('/brands/{brandId}', 'BrandController@show');
$app->post('/brands', 'BrandController@save');
$app->put('/brands/{brandId}', 'BrandController@edit');
$app->delete('/brands/{brandId}', 'BrandController@destroy');

// Mobile Phone Models
$app->get('/brands/{brandId}/mobilephonemodels', 'MobilePhoneModelController@index');
$app->get('/brands/{brandId}/mobilephonemodels/{mobilePhoneModelId}', 'MobilePhoneModelController@show');
$app->post('/brands/{brandId}/mobilephonemodels', 'MobilePhoneModelController@save');
$app->put('/brands/{brandId}/mobilephonemodels/{mobilePhoneModelId}', 'MobilePhoneModelController@edit');
$app->delete('/brands/{brandId}/mobilephonemodels/{mobilePhoneModelId}', 'MobilePhoneModelController@destroy');

// Spare Parts
$app->get('/brands/{brandId}/mobilephonemodels/{mobilePhoneModelId}/spareparts', 'SparePartController@index');
$app->get('/brands/{brandId}/mobilephonemodels/{mobilePhoneModelId}/spareparts/{sparePartId}', 'SparePartController@show');
$app->post('/brands/{brandId}/mobilephonemodels/{mobilePhoneModelId}/spareparts', 'SparePartController@save');
$app->put('/brands/{brandId}/mobilephonemodels/{mobilePhoneModelId}/spareparts', 'SparePartController@edit');
$app->delete('/brands/{brandId}/mobilephonemodels/{mobilePhoneModelId}/spareparts/{sparePartId}', 'SparePartController@destroy');

// Storages
$app->get('/stores/{storeId}/storages', 'StorageController@show');
$app->get('/stores/{storeId}/storages/spareparts/{sparePartId}', 'StorageController@showSparePart');

// Clients
$app->get('/clients', 'ClientController@index');
$app->get('/clients/{clientId}', 'ClientController@show');

// Clients
$app->get('/workorderstatuses', 'WorkOrderStatusController@index');
$app->get('/workorderstatuses/{workOrderStatusId}', 'WorkOrderStatusController@show');


// Request an access token
$app->post('/oauth/access_token', function() use ($app){
    return response()->json($app->make('oauth2-server.authorizer')->issueAccessToken());
});
