<?php

namespace App\Repositories\Order;

use App\Helper\Helper;
use App\Models\Order;

class ReturnOrderRepository implements ReturnOrderInterface
{
  use Helper;
  protected $order;

  public function __construct(Order $order)
  {
    $this->order = $order;
  }

  public function getAll()
  {
    return $this->order->latest()
      ->with('user', 'addresses', 'addresses.country', 'addresses.city', 'orderItems')
      ->where('return_order', true)
      ->filter(request()->input('order_number'))
      ->paginate();
  }

  public function show($id)
  {
    return $this->order->with('user', 'addresses', 'addresses.country', 'addresses.city', 'orderItems')
    ->findOrFail($id);
  }

  public function update($request, $id)
  {
    $order = $this->order->findOrFail($id);
    $order->update([
      'status' => $request->status,
    ]);

    return $order;
  }

  public function delete($id)
  {
    $order = $this->order->findOrFail($id);
    $order->delete();

    return $order;
  }
}
