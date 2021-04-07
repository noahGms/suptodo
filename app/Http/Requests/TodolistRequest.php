<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodolistRequest extends FormRequest
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
            'name' => 'required|max:45',
            'participants' => 'sometimes|array',
            'participants.*' => 'sometimes|required|exists:users,id',
            'permissions' => 'sometimes|array',
            'permissions.*.id' => 'sometimes|required|exists:users,id',
            'permissions.*.mode' => 'sometimes|required|string',
            'permissions.*.value' => 'sometimes|required|boolean',
        ];
    }
}
