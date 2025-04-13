<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 */
class OrderResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'passenger' => $this->passenger,
            'destination' => $this->destination,
            'departure_at' => $this->departure_at->format('Y-m-d'),
            'return_at' => $this->return_at->format('Y-m-d'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'status' => OrderStatusResource::make($this->status),
        ];
    }
}