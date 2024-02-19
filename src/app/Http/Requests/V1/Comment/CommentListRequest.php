<?php

namespace App\Http\Requests\V1\Comment;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CommentListRequest extends FormRequest
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
            'commentable_id' => 'required',
            'limit'          => 'nullable|integer|min:5|max:100',
            'page'           => 'nullable|integer',
            'per_page'       => 'nullable|integer|min:5|max:100',
        ];
    }
}
