<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Order;
use App\OrderItem;
use App\Inventory;
use App\InventoryItem;
use Faker\Generator as Faker;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->call(OrderStatusSeeder::class);
      $users = factory(App\User::class, 3)
      	->create();

			$inventory = factory(App\Inventory::class)->create();

			factory(App\InventoryItem::class, 5)->create([
				'inventory_id' => $inventory->id,
			]);
    }
}
