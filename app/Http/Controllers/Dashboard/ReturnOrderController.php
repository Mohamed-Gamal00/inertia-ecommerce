<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\Order\ReturnOrderRepository;
use Illuminate\Http\Request;

class ReturnOrderController extends Controller
{
    protected $returnOrderRepository;

    public function __construct(ReturnOrderRepository $repo)
    {
        $this->returnOrderRepository = $repo;
    }

    public function index()
    {
        $orders = $this->returnOrderRepository->getAll();

        return view('dashboard.return_order.index', compact('orders'));
    }

    public function show(string $id)
    {
        $order    = $this->returnOrderRepository->show($id);
        $statuses = OrderStatus::cases();

        return view('dashboard.return_order.show', compact('order', 'statuses'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => ['required', \Illuminate\Validation\Rules\Enum::class(OrderStatus::class)],
        ]);

        $this->returnOrderRepository->update($request, $id);

        return redirect()->route('return_orders.index')
            ->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function destroy(string $id)
    {
        $this->returnOrderRepository->delete($id);

        return redirect()->back()->with('dark', __('messages.RETURN_ORDER_DELETE'));
    }
}
