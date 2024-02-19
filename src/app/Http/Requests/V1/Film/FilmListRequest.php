<?php

namespace App\Http\Requests\V1\Film;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FilmListRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'search'          => 'nullable',
            'search_text'     => 'nullable',
            'with_text'       => 'nullable|boolean',
            'limit'           => 'nullable|integer|min:5|max:100',
            'page'            => 'nullable|integer',
            'per_page'        => 'nullable|integer|min:5|max:100'
        ];
    }
}
