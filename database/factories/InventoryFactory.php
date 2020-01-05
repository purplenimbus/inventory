<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Inventory;
use App\InventoryItem;
use Faker\Generator as Faker;

$factory->define(Inventory::class, function (Faker $faker) {
    return [
    	'name' => $faker->company(),
    	'description' => $faker->sentence(),
    ];
});

$factory->define(InventoryItem::class, function (Faker $faker) {
    return [
    	'description' => $faker->sentence(),
    	'quantity' => $faker->numberBetween(1, 100),
    	'price' => $faker->randomFloat(2, 5, 100),
    ];
});

