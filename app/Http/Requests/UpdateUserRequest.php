<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name'    => [
                'required',
            ],
            'email'   => [
                'required',
                'unique:users,email,' . request()->route('user')->id,
            ],
            'roles.*' => [
                'integer',
            ],
            'roles'   => [
                'required',
                'array',
            ],
            'phone_number'  => [
                'required',
                'regex:/^\?[0-9]{10,15}$/',
            ],
            'date_of_birth' => [
                'required',
                'date',
                'before:today',
            ],
        ];
    }
}
