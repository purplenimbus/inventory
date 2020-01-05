<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Order;
use App\Http\Requests\ShowOrder;
use App\Http\Requests\StoreOrder;
use App\Http\Requests\UpdateOrder;
use Illuminate\Http\Request;
use App\Rules\InStock;

class OrderController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Order::with(['items','status'])->paginate(10);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreOrder $request)
  {
    $request->validate([
      'items.*.quantity' => new InStock($request->get('items')),
    ]);

    $order = new OrderService(Order::make($request->only(['user_id'])));

    return response()->json($order->placeOrder($request->items));
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function show(ShowOrder $order)
  {
    return Order::with('items')->find($order->id);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateOrder $request)
  {
    $request->validate([
      'items.*.quantity' => new InStock($request->get('items')),
    ]);

    $order = new OrderService(Order::find($request->id));

    return response()->json($order->updateOrder($request->items));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function destroy(ShowOrder $order)
  {
    Order::destroy($order->id);

    return response()->json(['status' => true]);
  }
}
