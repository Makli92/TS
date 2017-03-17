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

// Users
$app->get('/users/', 'UserController@getUsers');
$app->post('/users/', 'UserController@createUser');
$app->get('/users/{userId}', 'UserController@getUser');
$app->put('/users/{userId}', 'UserController@updateUser');
$app->patch('/users/{userId}', 'UserController@updateUser');
$app->delete('/users/{userId}', 'UserController@deleteUser');

// Brands
$app->get('/brands', 'BrandController@getBrands');
$app->post('/brands', 'BrandController@createBrand');
$app->get('/brands/{brandId}', 'BrandController@getBrand');
$app->put('/brands/{brandId}', 'BrandController@updateBrand');
$app->delete('/brands/{brandId}', 'BrandController@deleteBrand');

/*
// Stores
$app->get('/stores', 'StoreController@index');
$app->get('/stores/{storeId}', 'StoreController@show');
$app->post('/stores', 'StoreController@save');
$app->put('/stores/{storeId}', 'StoreController@edit');
$app->delete('/stores/{storeId}', 'StoreController@destroy');



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

// Work Orders
$app->get('/workorders', 'WorkOrderController@index');
$app->get('/workorders/{workOrder}', 'WorkOrderController@show');
*/
// Request an access token
$app->post('/oauth/access_token', function() use ($app){
    return response()->json($app->make('oauth2-server.authorizer')->issueAccessToken());
});
