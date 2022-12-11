<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'title' => ['string', 'required', 'max:255'],
            'description' => ['string'],
            'type' => ['string', 'required', 'in:PRIVATE,PUBLIC'],
            'groups' => ['array'],
            'groups.*' => ['string']
        ];
    }
}
