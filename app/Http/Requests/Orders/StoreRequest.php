<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'passenger' => [
                'required',
            ],
            'destination' => [
                'required',
            ],
            'departure_at' => [
                'required',
                'date_format:Y-m-d',
            ],
            'return_at' => [
                'required',
                'date_format:Y-m-d',
            ],
        ];
    }
}