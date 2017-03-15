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
        'postcode' => $faker->postcode,
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

$factory->define(App\Models\SparePart::class, function (Faker\Generator $faker) {
    return [
        'mobilephonemodel_id' => mt_rand(1, 10),
        'intrastat_code' => $faker->ean13,
        'price' => mt_rand(1, 10),
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
        'user_level' => mt_rand(1, 3)
    ];
});

$factory->define(App\Models\WorkOrderStatus::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});