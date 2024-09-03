<?php

namespace App\Http\Requests\Auth;

use App\Models\Session;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SessionRevokeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', Rule::in($this->user()->sessions()->pluck('id'))]
        ];
    }

    public function messages(): array
    {
        return [
            'id.in' => "This isn't your session."
        ];
    }
}
