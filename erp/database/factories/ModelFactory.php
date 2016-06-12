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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Customer::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\zh_TW\Person($faker));
    $faker->addProvider(new Faker\Provider\zh_TW\Address($faker));
    $faker->addProvider(new Faker\Provider\zh_TW\PhoneNumber($faker));
    $faker->addProvider(new Faker\Provider\zh_TW\Company($faker));
    return [
        'name'          => $faker->company,
        'code'          => strtoupper($faker->randomLetter).$faker->randomNumber(4),
        'shortName'     => $faker->companyPrefix,
        'boss'          => $faker->name,
        'contactPerson' => $faker->name,
        'zip'           => $faker->postcode,
        'address'       => $faker->address,
        'email'         => $faker->email,
        'telphone'      => $faker->PhoneNumber,
        'cellphone'     => $faker->PhoneNumber,
        'fax'           => $faker->phoneNumber,
        'taxNumber'     => $faker->randomNumber(8),
        'tax_rate_id'   => $faker->randomElement(['1','2','3']),
        'pay_way_id'    => $faker->randomElement(['6','7','8', '9', '10', '11']),
    ];
});

$factory->define(App\Supplier::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\zh_TW\Person($faker));
    $faker->addProvider(new Faker\Provider\zh_TW\Address($faker));
    $faker->addProvider(new Faker\Provider\zh_TW\PhoneNumber($faker));
    $faker->addProvider(new Faker\Provider\zh_TW\Company($faker));
    return [
        'name'          => $faker->company,
        'code'          => strtoupper($faker->randomLetter).$faker->randomNumber(4),
        'shortName'     => $faker->companyPrefix,
        'boss'          => $faker->name,
        'contactPerson' => $faker->name,
        'zip'           => $faker->postcode,
        'address'       => $faker->address,
        'email'         => $faker->email,
        'telphone'      => $faker->PhoneNumber,
        'cellphone'     => $faker->PhoneNumber,
        'fax'           => $faker->phoneNumber,
        'taxNumber'     => $faker->randomNumber(8),
    ];
});

$factory->define(App\Stock::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\zh_TW\Person($faker));
    $faker->addProvider(new Faker\Provider\zh_TW\Address($faker));
    $faker->addProvider(new Faker\Provider\zh_TW\PhoneNumber($faker));
    $faker->addProvider(new Faker\Provider\zh_TW\Company($faker));
    return [
        'code'                      => $faker->randomNumber(8),
        'name'                      => $faker->name,
        'stock_class_id'            => $faker->randomElement([13, 14, 15]),
        'unit_id'                   => $faker->randomElement([10, 11, 12]),
        'net_weight'                => $faker->randomFloat(5, 0, 500),
        'gross_weight'              => $faker->randomFloat(5, 0, 500),
        'no_tax_price_of_purchased' => $faker->randomFloat(5, 0, 1000),
        'no_tax_price_of_sold'      => $faker->randomFloat(5, 0, 1000),
        'note'                      => $faker->realText,
    ];
});