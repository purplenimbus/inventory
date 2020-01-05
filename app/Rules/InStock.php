<?php
namespace App\Rules;

use App\InventoryItem;
use Illuminate\Contracts\Validation\Rule;

class InStock implements Rule
{
  public $items;
  public $inventoryItem;
  /**
   * Create a new rule instance.
   *
   * @return void
   */
  public function __construct($items)
  {
    $this->items = $items;
  }

  /**
   * Determine if the validation rule passes.
   *
   * @param  string  $attribute
   * @param  mixed  $quantity
   * @return bool
   */
  public function passes($attribute, $quantity)
  {
    $inventoryItemId = $this->items[$this->getIndex($attribute)]['inventory_item_id'];

    $this->inventoryItem = InventoryItem::find($inventoryItemId);

    return $this->inventoryItem->quantity >= $quantity;
  }

  /**
   * Get the validation error message.
   *
   * @return string
   */
  public function message()
  {
    return "requested quantity not in stock ";
  }

  private function getIndex($attribute){
    return intval(explode('.', $attribute)[1]);
  }
}
