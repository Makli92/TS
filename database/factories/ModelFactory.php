<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
$factory->define(App\Models\Store::class, function (Faker\Generator $faker) {
    return [
        'street' => $faker->streetName,
        'street_number' => $faker->streetAddress,
        'phone_number' => $faker->phoneNumber,
        'post_code' => $faker->postcode,
        'city' => $faker->city,
        'country' => $faker->country,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude
    ];
});

$factory->define(App\Models\Brand::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(App\Models\MobilePhoneModel::class, function (Faker\Generator $faker) {
    return [
        'brand_id' => mt_rand(1, 10),
        'name' => $faker->word
    ];
});

$factory->define(App\Models\Client::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone_number' => $faker->phoneNumber,
        'mobile_number' => $faker->phoneNumber,
        'email' => $faker->email,
        'created_by_user_id' => mt_rand(1, 10),
        'store_id' => mt_rand(1, 10)
    ];
});

$factory->define(App\Models\SparePart::class, function (Faker\Generator $faker) {
    return [
        'mobile_phone_model_id' => mt_rand(1, 10),
        'intrastat_code' => $faker->ean13,
        'net_value' => mt_rand(1, 10),
        'min_vol' => mt_rand(10, 100),
        'description' => $faker->paragraph
    ];
});

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {

    $hasher = app()->make('hash');
    
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => $hasher->make("secret"),
        'user_level' => mt_rand(1, 4),
        'is_active' => mt_rand(0, 1)
    ];
});

$factory->define(App\Models\WorkOrder::class, function (Faker\Generator $faker) {
    return [
        'client_id' => mt_rand(1, 100),
        'imei' => $faker->isbn13,
        'description' => $faker->sentence,
        'notes' => $faker->sentence,
        'technician_id' => mt_rand(1, 10),
        'work_order_status_id' => mt_rand(1, 5)
    ];
});

$factory->define(App\Models\Device::class, function (Faker\Generator $faker) {
    return [
        'mobile_phone_model_id' => mt_rand(1, 20),
        'imei' => $faker->isbn13
    ];
});

$factory->define(App\Models\WorkOrder::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->paragraph,
        'notes' => $faker->paragraph,
        'assigned_to' => mt_rand(1, 10),
        'client_id' => mt_rand(1, 100),
        'status_id' => mt_rand(1, 9),
        'device_id' => mt_rand(1, 50),
        'created_by' => mt_rand(1, 10),
        'store_id' => mt_rand(1, 10)
    ];
});