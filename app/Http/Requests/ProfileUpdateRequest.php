<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:50'],
            'email' => ['email:rfc,dns', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
        ];
    }
}
