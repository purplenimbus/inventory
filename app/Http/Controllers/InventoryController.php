<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\InventoryItem;
use App\Http\Requests\ShowInventory;
use App\Http\Requests\StoreInventory;
use App\Http\Requests\UpdateInventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Inventory::with('items')->paginate(10);
  }

  /**
   * Store a new resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreInventory $request)
  {
    $inventory = Inventory::create($request->all());

    return response()->json($inventory);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Inventory  $inventory
   * @return \Illuminate\Http\Response
   */
  public function show(ShowInventory $inventory)
  {
    return InventoryItem::where('inventory_id', $inventory->id)
      ->paginate(10);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Inventory  $inventory
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateInventory $request)
  {
    $inventory = Inventory::find($request->id);

    if($request->has('items')){
      foreach($request->get('items') as $item){
        $item['inventory_id'] = $inventory->id;

        InventoryItem::create($item);
      };
    }

    return $inventory->load('items');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Inventory  $inventory
   * @return \Illuminate\Http\Response
   */
  public function destroy(ShowInventory $inventory)
  {
    Inventory::destroy($inventory->id);

    return response()->json(['status' => true]);
  }
}
