<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\DoesNotAllowCancellationOrder;
use App\Http\Requests\Orders\ChangeStatusRequest;
use App\Http\Requests\Orders\StoreRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 *
 */
class OrderController extends Controller
{
    /**
     * @param OrderService $service
     */
    public function __construct(protected OrderService $service)
    {
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $response = $this->service->index($request);
        return OrderResource::collection($response);
    }

    /**
     * @param StoreRequest $request
     * @return OrderResource
     */
    public function store(StoreRequest $request): OrderResource
    {
        $response = $this->service->store($request->validated(), $request->user());
        return OrderResource::make($response);
    }

    /**
     * @param Order $order
     * @return OrderResource
     */
    public function show(Order $order): OrderResource
    {
        $response = $this->service->show($order);
        return OrderResource::make($response);
    }

    /**
     * @throws DoesNotAllowCancellationOrder
     */
    public function changeStatus(ChangeStatusRequest $request, Order $order): OrderResource
    {
        $response = $this->service->changeStatus($request->validated(), $order);
        return OrderResource::make($response);
    }
}