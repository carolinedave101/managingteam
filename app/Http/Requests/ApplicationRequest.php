<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'bio' => ['required', 'string', 'min:50'],
            'reason' => ['required', 'string', 'min:50'],
            'social_links' => ['nullable', 'string', 'max:500'],
            'payment_method' => ['nullable', 'string'],
            'payment_proof' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,pdf', 'max:5120'],
        ];
    }
}
