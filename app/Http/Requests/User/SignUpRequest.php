<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

   

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->type == 'register')
            return [
                'name'              => 'required',
                'email'             => 'required|email|unique:users,email',
                'mobile'            => 'nullable|integer',
                'password'          => 'required|min:8',
                'confirm_password'  => 'required|same:password',
            ];
        else
            return [
                'email' => 'required|exists:users,email',
            ];
    }
}
