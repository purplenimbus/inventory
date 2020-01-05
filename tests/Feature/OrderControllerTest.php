<?php

namespace Tests\Feature;

use App\Inventory;
use App\InventoryItem;
use App\Order;
use App\OrderItem;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Generator as Faker;

class OrderControllerTest extends TestCase
{
  use RefreshDatabase;

  public $inventory;
  public $orders;
  public $user;

  private function createInventoryData(){
    $this->user = factory(User::class)->create();
    $this->inventory = factory(Inventory::class, 1)->create()
      ->each(function($inventory){
        factory(InventoryItem::class, 5)->create([
          'inventory_id' => $inventory->id,
        ]);
      });
  }

  private function createOrderData(){
    $this->orders = factory(Order::class, 1)->create([
      'user_id' => $this->user->id,
    ])->each(function($order) {
      factory(OrderItem::class)->create([
        'inventory_item_id' => $this->inventory->first()->items->first()->id,
        'order_id' => $order->id,
        'quantity' => rand(0, $this->inventory->first()->items->first()->quantity)
      ]);

      factory(OrderItem::class)->create([
        'inventory_item_id' => $this->inventory->first()->items->first()->id,
        'order_id' => $order->id,
        'quantity' => rand(0, $this->inventory->first()->items->first()->quantity)
      ]);
    });
  }

  /**
   * A basic feature test example.
   *
   * @return void
   */
  public function testIndex()
  {
    $response = $this->get('/api/orders');

    $response->assertStatus(200);
  }

  /**
  * test store route
  *
  * @return void
  */
  public function testStore()
  {
    $this->createInventoryData();

    $badResponse = $this->json('POST', '/api/orders', []);

    $badResponse->assertStatus(422);

    $goodResponse = $this->json('POST', '/api/orders', [
      'user_id' => $this->user->id,
      'items' => [
        [
          'inventory_item_id' => $this->inventory->first()->items->first()->id,
          'quantity' => 1,
        ]
      ]
    ]);

    $goodResponse->assertSuccessful();
  }

  /**
  * test show route
  *
  * @return void
  */
  public function testShow()
  {
    $this->createInventoryData();
    $this->createOrderData();

    $orderId = Order::first()->id;

    $goodResponse = $this->json('GET', "/api/orders/{$orderId}");

    $goodResponse->assertSuccessful();

    $badResponse = $this->json('GET', '/api/inventories/100');

    $badResponse->assertStatus(422);
  }

  /**
   * test update route
   *
   * @return void
   */
  public function testUpdate()
  {
    $this->createInventoryData();
    $this->createOrderData();
    $payload = [
      'items' => [
        [
          'inventory_item_id' => $this->inventory->first()->items->first()->id,
          'quantity' => 1,
        ]
      ]
    ];

    $order = $this->orders->first();
    $goodResponse = $this->json('PUT', "/api/orders/{$order->id}", $payload);

    $goodResponse->assertSuccessful();
    $this->assertEquals(Order::latest()
      ->first()
      ->items
      ->count(), $order->items->count());

    $badResponse = $this->json('PUT', '/api/orders/100', []);

    $badResponse->assertStatus(422);

    $payload2 = $payload;
    $payload2['items']['inventory_item_id'] = 10000;
    $badResponseWithItems = $this->json('PUT', "/api/orders/{$order->id}", $payload2);

    $badResponseWithItems->assertStatus(422);

    $payload3 = $payload;
    $payload3['items']['quantity'] = 10000;
    $badResponseWithItems = $this->json('PUT', "/api/orders/{$order->id}", $payload2);

    $badResponseWithItems->assertStatus(422);
  }
  /**
   * test delete route
   *
   * @return void
   */
  public function testDestroy()
  {
    $this->createInventoryData();
    $this->createOrderData();

    $goodResponse = $this->json('DELETE', "/api/orders/{$this->orders->first()->id}");

    $goodResponse->assertSuccessful();
    $this->assertEquals(Order::all()
      ->count(), 0);
    $this->assertEquals(OrderItem::where('order_id', $this->orders->first()->id)
      ->count(), 0);

    $badResponse = $this->json('DELETE', '/api/inventories/100');

    $badResponse->assertStatus(422);
  }
}
