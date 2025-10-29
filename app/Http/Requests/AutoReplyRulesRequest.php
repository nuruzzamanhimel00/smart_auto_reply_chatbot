<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AutoReplyRulesRequest extends FormRequest
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
        // dd(request()->all());
        $rules = [
            'keyword'            => ['required', 'string', 'max:100'],
            'reply'             => ['nullable', 'string', 'max:500'],
            "priority"           => ['required', 'integer'],
            'status'                => 'required',

        ];

        return $rules;
    }
}
