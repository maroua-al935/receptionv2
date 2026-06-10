<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = $this->route('user')->id ?? null;

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'profile' => 'required|exists:profiles,id',
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'services' => 'nullable|array',
            'services.*' => 'exists:groups,id',
            'head_services' => 'nullable|array',
            'head_services.*' => 'exists:groups,id',
            'antennes' => 'nullable|array',
            'antennes.*' => 'exists:antennes,id',
            'head_antennes' => 'nullable|array',
            'head_antennes.*' => 'exists:antennes,id',
        ];
    }
}
