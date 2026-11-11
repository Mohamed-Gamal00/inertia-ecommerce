<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->getAll();
        $user   = Auth::guard('admin')->user();
        $notifications = $user->notifications()
            ->where('type', "App\Notifications\OrderCreatedNotification")
            ->get();

        return view('dashboard.orders.index', compact('orders', 'notifications'));
    }

    public function show(string $id)
    {
        $order   = $this->orderRepository->show($id);
        $statuses = OrderStatus::cases();

        return view('dashboard.orders.show', compact('order', 'statuses'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => ['required', new Enum(OrderStatus::class)],
        ]);

        $this->orderRepository->update($request, $id);

        return redirect()->route('orders.index')
            ->with('success', __('messages.ORDER_STATUS_UPDATED'));
    }

    public function destroy(string $id)
    {
        $this->orderRepository->delete($id);

        return redirect()->back()->with('dark', __('messages.ORDER_DELETED'));
    }
}
