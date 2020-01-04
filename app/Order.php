<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'status_id', 'user_id',
  ];

  /**
   * Get the order items owned by this order
   *
   */
  public function items() {
  	$this->hasMany('App\OrderItem');
  }

  /**
   * Get the user that owns this order
   *
   */
  public function user() {
  	$this->belongsTo('App\User');
  }

  /**
   * Get the order status
   *
   */
  public function status() {
  	$this->hasOne('App\OrderStatus');
  }
}
