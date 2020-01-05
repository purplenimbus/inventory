<?php

namespace App\Services;
use App\Order;
use App\OrderItem;
use Illuminate\Http\Request;

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
}