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
$app->get('/users', 'UserController@getUsers');
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

// Mobile Phone Models
$app->get('/mobilephonemodels', 'MobilePhoneModelController@getMobilePhoneModels');
$app->get('/brands/{brandId}/mobilephonemodels', 'MobilePhoneModelController@getMobilePhoneModelsByBrandId');
$app->post('/brands/{brandId}/mobilephonemodels', 'MobilePhoneModelController@createMobilePhoneModel');
$app->get('/brands/{brandId}/mobilephonemodels/{mobilePhoneModelId}', 'MobilePhoneModelController@getMobilePhoneModel');

// Spare Parts
$app->get('/spareparts', 'SparePartController@getSpareParts');
$app->get('/spareparts/{sparePartId}', 'SparePartController@getSparePart');
$app->get('/mobilephonemodels/{mobilePhoneModelId}/spareparts', 'SparePartController@getSparePartsByMobilePhoneModelId');

// Work Orders
$app->get('/workorderstatuses', 'WorkOrderStatusController@getWorkOrderStatuses');
$app->get('/workorderstatuses/{workOrderStatusId}', 'WorkOrderStatusController@getWorkOrderStatus');

// VAT values
$app->get('/vats', 'VATController@getVATs');
$app->post('/vats', 'VATController@createVAT');
$app->get('/vats/{vatId}', 'VATController@getVAT');
$app->put('/vats/{vatId}', 'VATController@updateVAT');
$app->delete('/vats/{vatId}', 'VATController@deleteVAT');

// Device
$app->get('/devices', 'DeviceController@getDevices');
$app->post('/devices', 'DeviceController@createDevice');
$app->get('/devices/{deviceId}', 'DeviceController@getDevice');
$app->put('/devices/{deviceId}', 'DeviceController@updateDevice');
$app->delete('/devices/{deviceId}', 'DeviceController@deleteDevice');

// Store
$app->get('/stores', 'StoreController@getStores');
$app->get('/stores/{storeId}/users', 'StoreController@getStaff');
$app->post('/stores', 'StoreController@createStore');
$app->get('/stores/{storeId}', 'StoreController@getStore');
$app->put('/stores/{storeId}', 'StoreController@updateStore');
$app->delete('/stores/{storeId}', 'StoreController@deleteStore');

//Clients
$app->get('/clients', 'ClientController@getClients');
$app->get('/clients/{clientId}', 'ClientController@getClient');
$app->get('/admin/clients', 'ClientController@getClientsAdmin');
$app->get('/stores/{storeId}/clients', 'ClientController@getClientsAdminByStore');

// WorkOrders
$app->get('/workorders', 'WorkOrderController@getWorkOrders');
$app->post('/workorders', 'WorkOrderController@createWorkOrder');
$app->get('/stores/{storeId}/workorders', 'WorkOrderController@getWorkOrdersByStoreId');
$app->get('/workorders/{workOrderId}', 'WorkOrderController@getWorkOrder');
$app->get('/stores/{storeId}/workorders/{workOrderId}', 'WorkOrderController@getWorkOrder');

// Request an access token
$app->post('/oauth/access_token', function() use ($app){
    return response()->json($app->make('oauth2-server.authorizer')->issueAccessToken());
});
