<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CharacterRequest extends Request
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
        $rules = [
            'name' => 'required|min:3|max:20',
            'class' => 'required|integer|exists:classes,id',
            'script' => 'required|integer|script_from_user'
        ];

        return $rules;
    }
}
