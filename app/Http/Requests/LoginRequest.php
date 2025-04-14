<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 *
 */
class LoginRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required',
                Password::defaults()
            ]
        ];
    }
}