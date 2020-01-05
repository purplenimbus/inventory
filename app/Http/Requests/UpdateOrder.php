<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrder extends FormRequest
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
      'id' => 'required|integer|exists:orders,id',
      'items' => 'required|array',
      'items.*.inventory_item_id' => 'integer|required|exists:inventory_items,id|distinct',
      'items.*.quantity' => 'integer|required|min:1',
    ];
  }

  public function all($keys = null) 
  {
    $data = parent::all();
    $data['id'] = $this->route('order');
    return $data;
  }
}
