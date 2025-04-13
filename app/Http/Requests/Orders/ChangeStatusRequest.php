<?php

namespace App\Http\Requests\Orders;

use App\Enums\OrderStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
                Rule::in([OrderStatus::APPROVED, OrderStatus::APPROVED]),
                function ($attribute, $value, $fail) {
                    if ($value === request()->route('order')->status) {
                        $fail('The order is already in this status.');
                    }
                }
            ],
        ];
    }
}