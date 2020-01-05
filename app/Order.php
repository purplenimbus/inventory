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
  	return $this->hasMany('App\OrderItem', 'order_id', 'id');
  }

  /**
   * Get the user that owns this order
   *
   */
  public function user() {
  	return $this->belongsTo('App\User');
  }

  /**
   * Get the order status
   *
   */
  public function status() {
  	return $this->hasOne('App\OrderStatus', 'id', 'status_id');
  }

  public static function boot() {
    parent::boot();

    static::deleting(function($order) { 
      $order->items()->delete();
    });
  }
}
