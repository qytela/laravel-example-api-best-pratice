<?php

namespace App\Http\Requests\Article;

use App\Http\Requests\PaginateRequest;

class IndexRequest extends PaginateRequest
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
            'title' => [''],
            'type' => ['string', 'in:PRIVATE,PUBLIC']
        ];
    }
}
