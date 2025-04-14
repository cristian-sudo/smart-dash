<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'logo' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png,gif'],
        ];
    }

    public function messages(): array
    {
        return [
            'logo.image' => 'The logo must be an image file.',
            'logo.max' => 'The logo must not be larger than 2MB.',
            'logo.mimes' => 'The logo must be a file of type: jpg, jpeg, png, or gif.',
        ];
    }
} 