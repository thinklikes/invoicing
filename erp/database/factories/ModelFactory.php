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

$factory->define(Company\Company::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\zh_TW\Person($faker));
    $faker->addProvider(new Faker\Provider\zh_TW\Address($faker));
    $faker->addProvider(new Faker\Provider\zh_TW\PhoneNumber($faker));
    $faker->addProvider(new Faker\Provider\zh_TW\Company($faker));

    return [
        'company_code'      => strtoupper($faker->randomLetter).$faker->randomNumber(4),
        'company_name'      => $faker->company,
        'mailbox'           => $faker->randomNumber(3),
        'company_abb'       => $faker->companyPrefix,
        'company_contact'   => $faker->name,
        'company_con_tel'   => $faker->phoneNumber,
        'company_con_email' => $faker->email,
        'boss'              => $faker->name,
        'company_tel'       => $faker->phoneNumber,
        'company_fax'       => $faker->phoneNumber,
        'company_add'       => $faker->address,
        'VTA_NO'            => $faker->randomNumber(8),
        'company_remark'    => $faker->realText,
    ];
});

$factory->define(Supplier\Supplier::class, function (Faker\Generator $faker) {
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

$factory->define(Stock\Stock::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\zh_TW\Person($faker));

    $collection = DB::table('erp_options')
    ->select('id')
    ->where('class', 'stock_classes')
    ->get();

    $stock_classes = array();

    foreach ($collection as $value) {
        $stock_classes[] = $value->id;
    }

    $collection = DB::table('erp_options')
    ->select('id')
    ->where('class', 'units')
    ->get();

    $units = array();

    foreach ($collection as $value) {
        $units[] = $value->id;
    }

    return [
        'code'                      => $faker->randomNumber(8),
        'name'                      => $faker->name,
        'stock_class_id'            => $faker->randomElement($stock_classes),
        'unit_id'                   => $faker->randomElement($units),
        'net_weight'                => $faker->randomFloat(5, 0, 500),
        'gross_weight'              => $faker->randomFloat(5, 0, 500),
        'no_tax_price_of_purchased' => $faker->randomFloat(5, 0, 1000),
        'no_tax_price_of_sold'      => $faker->randomFloat(5, 0, 1000),
        'note'                      => $faker->realText,
    ];
});

$factory->define(BillOfPurchase\BillOfPurchaseMaster::class, function (Faker\Generator $faker) {
    $collection = DB::table('erp_warehouse')
    ->select('id')
    ->get();

    $warehouses = array();

    foreach ($collection as $value) {
        $warehouses[] = $value->id;
    }

    return [
        'code' => date('Ymd').sprintf('%03d', $faker->unique()->numberBetween(1, 50)),
        'invoice_code' => $faker->randomLetter.$faker->randomLetter.$faker->randomNumber(8),
        'warehouse_id' => $faker->randomElement($warehouses),
        'supplier_id'  => $faker->numberBetween(1, 50),
        'tax_rate_code'=> $faker->randomElement(['A', 'I']),
        'note'         => $faker->realText
    ];
});

$factory->define(BillOfPurchase\BillOfPurchaseDetail::class, function (Faker\Generator $faker) {
    return [
        'master_code' => date('Ymd').sprintf('%03d', $faker->numberBetween(1, 50)),
        'stock_id' => $faker->unique()->numberBetween(1, 50),
        'quantity' => $faker->numberBetween(1, 50),
        'no_tax_price'  =>  $faker->randomFloat(5, 0, 500),
    ];
});

$factory->define(Stock\StockWarehouse::class, function (Faker\Generator $faker) {
    $collection = DB::table('erp_warehouse')
    ->select('id')
    ->get();

    $warehouses = array();

    foreach ($collection as $value) {
        $warehouses[] = $value->id;
    }

    return [
        'stock_id' => $faker->unique()->numberBetween(1, 50),
        'warehouse_id' => $faker->randomElement($warehouses),
        'inventory'  =>  $faker->randomFloat(5, 0, 500),
    ];
});