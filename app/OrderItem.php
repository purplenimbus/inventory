<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'status_id', 'iser_id',
  ];

  /**
   * Get the order that owns this items
   *
   */
  public function order() {
  	return $this->belongsTo('App\Order');
  }

  /**
   * Get the order items owned by this order
   *
   */
  public function inventoryItem() {
  	return $this->hasOne('App\InventoryItem');
  }
}
