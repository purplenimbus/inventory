<?php

namespace App\Services;
use App\Order;
use App\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OrderService
{
  public $order;

  function __construct($order)
  {
    $this->order = $order;
  }

  public function placeOrder($orderItems)
  {
  	$this->order->save();

  	foreach ($orderItems as $orderItem) {
  		$orderItem['order_id'] = $this->order->id;
  		OrderItem::create($orderItem);
  	}

  	return $this->order->load('items');
  }

  public function updateOrder($orderItems)
  {
  	foreach ($orderItems as $orderItem) {
  		$orderItem['order_id'] = $this->order->id;
  		OrderItem::updateOrCreate(Arr::only($orderItem, ['order_id','inventory_item_id']), Arr::only($orderItem, ['quantity']));
  	}

  	$this->order->touch();

  	return $this->order->load('items');
  }
}