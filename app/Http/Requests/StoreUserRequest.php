<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name'     => [
                'required',
            ],
            'email'    => [
                'required',
                'unique:users',
            ],
            'password' => [
                'required',
            ],
            'roles.*'  => [
                'integer',
            ],
            'roles'    => [
                'required',
                'array',
            ],
            'phone_number'  => [
                'required',
                'regex:/^09\d{9}$/',
            ],
            'date_of_birth' => [
                'required',
                'date',
                'before:today',
            ],
        ];
    }
}
