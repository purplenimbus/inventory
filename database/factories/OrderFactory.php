<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use App\OrderItem;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
  return [];
});

$factory->define(OrderItem::class, function (Faker $faker) {
  return [];
});
