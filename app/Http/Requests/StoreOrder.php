<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'user_id' => 'required|integer|exists:users,id',
      'items' => 'required|array',
      'items.*.inventory_item_id' => 'integer|required|exists:inventory_items,id|distinct',
      'items.*.quantity' => 'integer|required|min:1',
      'status_id' => 'integer|exists:order_statuses,id',
    ];
  }
}
