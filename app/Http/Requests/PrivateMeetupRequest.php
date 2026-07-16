<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrivateMeetupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'date' => ['required', 'date', 'after:today'],
            'duration' => ['required', 'integer', 'in:30,60,90,120'],
            'location' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'string'],
            'payment_proof' => ['required_if:payment_method,!=,wallet', 'file', 'mimes:jpg,jpeg,png,gif,webp,pdf', 'max:5120'],
        ];
    }
}
