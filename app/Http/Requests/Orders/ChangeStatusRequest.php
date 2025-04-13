<?php

namespace App\Http\Requests\Orders;

use App\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ChangeStatusRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                new Enum(OrderStatus::class),
                function ($attribute, $value, $fail) {
                    if ($value === request()->route('order')->status->value) {
                        $fail('The order is already in this status.');
                    }
                }
            ],
        ];
    }
}