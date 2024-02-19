<?php

namespace App\Http\Requests\V1\Music;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MusicListRequest extends FormRequest
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
            'degree'          => 'nullable|integer',
            'music_video'     => 'nullable|boolean',
            'is_user_request' => 'nullable|boolean',
            'album_id'        => 'nullable|integer',
            'with_text'       => 'nullable|boolean',
            'singer_id'       => 'nullable|integer',
            'limit'           => 'nullable|integer|min:5|max:100',
            'random'          => 'nullable|integer',
            'page'            => 'nullable|integer',
            'per_page'        => 'nullable|integer|min:5|max:100',
            'order_by'        => 'nullable|string',
            'sort_by'         => 'nullable|boolean'
        ];
    }
}
