<?php
declare(strict_types=1);

namespace App\Services;

use App\Enums\OrderStatus;
use App\Exceptions\DoesNotAllowCancellationOrder;
use App\Exceptions\OrderStatusNotFound;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderApprovedNotify;
use App\Notifications\OrderCanceledNotify;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class OrderService
{
    /**
     * @param Request $request
     * @return Paginator
     */
    public function index(Request $request): Paginator
    {
        return Order::with(['user'])
            ->when($request->filled('passenger'), function ($query) use ($request) {
                $query->where('passenger', 'like', '%' . $request->input('passenger') . '%');
            })
            ->when($request->filled('departure_at.start'), function ($query) use ($request) {
                $query->where('departure_at', '>=', $request->input('departure_at.start'));
            })
            ->when($request->filled('departure_at.end'), function ($query) use ($request) {
                $query->where('departure_at', '<=', $request->input('departure_at.end'));
            })
            ->when($request->filled('return_at.start'), function ($query) use ($request) {
                $query->where('return_at', '>=', $request->input('return_at.start'));
            })
            ->when($request->filled('return_at.end'), function ($query) use ($request) {
                $query->where('return_at', '<=', $request->input('return_at.end'));
            })
            ->when($request->filled('statuses'), function ($query) use ($request) {
                $query->whereIn('status', $request->input('statuses'));
            })
            ->orderByDesc('created_at')
            ->simplePaginate();
    }

    /**
     * @param array $data
     * @param User $user
     * @return Order
     */
    public function store(array $data, User $user): Order
    {
        return $user->orders()
            ->create($data)
            ->refresh();
    }

    /**
     * @param Order $order
     * @return Order
     */
    public function show(Order $order): Order
    {
        return $order;
    }

    /**
     * @param array $data
     * @param Order $order
     * @return Order
     * @throws DoesNotAllowCancellationOrder
     */
    public function changeStatus(array $data, Order $order): Order
    {
        if ($this->isCancellationOfApprovedOrder((int)data_get($data, 'status'), $order)
            && !config('onfly.allows_cancellation_approved_order')
        ) {
            throw new DoesNotAllowCancellationOrder();
        }

        DB::transaction(function () use ($data, $order) {
            $order->update($data);
            $this->sendNotify((int)data_get($data, 'status'), $order);
        });

        return $order->load('user');
    }

    protected function isCancellationOfApprovedOrder(int $status, Order $order): bool
    {
        return $status === OrderStatus::CANCELED && $order->status === OrderStatus::APPROVED;
    }

    /**
     * @param int $status
     * @param Order $order
     * @return void
     * @throws OrderStatusNotFound
     */
    protected function sendNotify(int $status, Order $order): void
    {
        dd($status, OrderStatus::APPROVED);
        match ($status) {
            OrderStatus::APPROVED => $order->notify(new OrderApprovedNotify()),
            OrderStatus::CANCELED => $order->notify(new OrderCanceledNotify()),
            default => throw new OrderStatusNotFound()
        };
    }
}