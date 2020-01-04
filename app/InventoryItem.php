<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'description', 'inventory_id', 'price', 'quantity',
  ];

  /**
   * Get the inventory that this item belongs to
   *
   */
  public function inventory() {
  	return $this->belongsTo('App\Inventory');
  }
}
