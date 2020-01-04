<?php

namespace Tests\Feature;

use App\Inventory;
use App\InventoryItem;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;

class InventoryControllerTest extends TestCase
{
  use RefreshDatabase;

  /**
   * test index route
   *
   * @return void
   */
  public function testIndex()
  {
    $response = $this->get('/api/inventories');

    $response->assertSuccessful(200);
  }

  /**
   * test store route
   *
   * @return void
   */
  public function testStore()
  {
    $badResponse = $this->json('POST', '/api/inventories', []);
    $badResponse->assertStatus(422);

    $inventory = factory(Inventory::class)->make();
    $goodResponse = $this->json('POST', '/api/inventories', $inventory->toArray());
    $goodResponse->assertSuccessful();
    $this->assertEquals($goodResponse->json()["id"], Inventory::latest()->first()->id);
  }

  /**
   * test show route
   *
   * @return void
   */
  public function testShow()
  {
    $inventory = factory(Inventory::class)->create();
    $inventoryId = Inventory::first()->id;
    $goodResponse = $this->json('GET', "/api/inventories/{$inventoryId}");
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
    $inventory = factory(Inventory::class)->create();
    $inventoryId = $inventory->id;
    $inventoryItems = factory(InventoryItem::class, 3)->make([
      'inventory_id' => $inventoryId,
    ])->toArray();

    $goodResponse = $this->json('PUT', "/api/inventories/{$inventoryId}");

    $goodResponse->assertSuccessful();
    $this->assertEquals(Inventory::latest()
      ->first()
      ->items
      ->count(), 0);

    $goodResponseWithItems = $this->json('PUT', "/api/inventories/{$inventoryId}", [
        'items' => $inventoryItems
      ]);

    $goodResponseWithItems->assertSuccessful();
    $this->assertEquals(Inventory::latest()
      ->first()
      ->items
      ->count(), 3);

    $badResponse = $this->json('PUT', '/api/inventories/100');

    $badResponse->assertStatus(422);

    $badResponseWithItems = $this->json('PUT', "/api/inventories/{$inventoryId}", [
        'items' => Arr::pluck($inventoryItems, 'price'),
      ]);

    $badResponseWithItems->assertStatus(422);
  }

  /**
   * test delete route
   *
   * @return void
   */
  public function testDestroy()
  {
    $inventories = factory(Inventory::class, 3)->create();

    $goodResponse = $this->json('DELETE', "/api/inventories/{$inventories->first()->id}");

    $goodResponse->assertSuccessful();
    $this->assertEquals(Inventory::all()
      ->count(), 2);

    $badResponse = $this->json('DELETE', '/api/inventories/100');

    $badResponse->assertStatus(422);
  }
}
