<?php

//use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(App\Models\Role::class, function (Faker\Generator $faker) {
    return [
        'code' => 'admin',
        'name' => 'Admin',
        'permissions' => 'u1,u2,i1,i2,e1,e2,et1,et2,g1,g2,gt1,gt2,c1,c2,sc1,sc2,m1,m2,sm1,sm2,ct1,ct2'
    ];
});

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;
    return [
        'full_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'role_id' => '1',
        'has_password' => '1',
        'birth_day' => '1999-09-08',
        'is_locked' => '0'
    ];
});

$factory->define(App\Models\SubMenu::class, function (Faker\Generator $faker) {
    return [
        'active' => true,
        'url' => $faker->url,
        'sequence' => 1,
        'menu_id' => 1
    ];
});

$factory->define(App\Models\SubCategory::class, function (Faker\Generator $faker) {
    return [
        'active' => true,
        'sequence' => 1,
        'slug' => 'sub-category-1',
        'category_id' => 1
    ];
});

$factory->define(App\Models\Promotion::class, function (Faker\Generator $faker) {
    return [
        'active' => true,
        'sequence' => 1,
        'slug' => 'promotion-1',
    ];
});

$factory->define(App\Models\Menu::class, function (Faker\Generator $faker) {
    return [
        'active' => true,
        'sequence' => 1,
    ];
});

$factory->define(App\Models\Item::class, function (Faker\Generator $faker) {
    return [
        'active' => true,
        'slug' => 'item-1',
        'price' => 100000,
        'item_type' => 1
    ];
});

$factory->define(App\Models\GalleryType::class, function (Faker\Generator $faker) {
    return [
        'active' => true,
        'slug' => 'gallery-type',
    ];
});

$factory->define(App\Models\Gallery::class, function (Faker\Generator $faker) {
    return [
        'name_en' => $faker->name,
        'name_vi' => $faker->name,
        'name_ja' => $faker->name,
        'gallery_type_id' => 1,
        'active' => true
    ];
});

$factory->define(App\Models\EventType::class, function (Faker\Generator $faker) {
    return [
        'slug' => 'event-type',
        'active' => true
    ];
});

$factory->define(App\Models\Event::class, function (Faker\Generator $faker) {
    return [
        'slug' => 'event-type',
        'event_type_id' => 1,
        'active' => true
    ];
});

$factory->define(App\Models\Currency::class, function (Faker\Generator $faker) {
    return [
        'code' => 'currency-code',
        'symbol' => 'Symbol',
        'exchange_rate' => 1000,
        'active' => true
    ];
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'active' => true,
        'sequence' => 1,
        'slug' => 'category-1',
    ];
});