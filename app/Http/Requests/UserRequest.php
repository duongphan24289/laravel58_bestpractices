<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'last_name' => 'required|string|max:30',
            'first_name' => 'required|string|max:30',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8|max:20',
            'confirm_password' => 'required|min:8|max:20|same:password'
        ];
    }

    public function messages()
    {
        return [];
    }
}
