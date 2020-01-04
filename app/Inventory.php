<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'description',
  ];

  /**
   * Get the inventory items owned by this inventory
   *
   */
  public function items() {
  	$this->hasMany('App\InventoryItem');
  }
}
