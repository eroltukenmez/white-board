<?php

namespace App\Http\Requests;

use App\Enums\ApplicationType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplicationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'source' => 'required',
            'location_id' => 'required',
            'description' => 'required',
            'type' => Rule::enum(ApplicationType::class)
        ];
    }

    protected function prepareForValidation(): void
    {
        $source = $this->is('api/*') || $this->expectsJson() ? 'service' : 'web';

        $this->merge([
            'user_id' => auth()->id(),
            'source' => $source
        ]);
    }
}
