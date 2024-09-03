<?php

namespace App\Http\Requests;

use App\Models\Department;
use App\Models\User;
use App\Services\DataTransferObjects\UserDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class ProfileUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone' => ['required'],
            'roles' => [Rule::requiredIf(fn()=> !$this->is('api/*')), 'array', Rule::in(Role::all()->pluck('id'))],
            'departments' => [Rule::requiredIf(fn()=> !$this->is('api/*')), 'array', Rule::in(Department::all()->pluck('id'))]
        ];
    }
}
