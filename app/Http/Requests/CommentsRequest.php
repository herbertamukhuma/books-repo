<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class CommentsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'book_isbn' => 'required|max:15',
            'comment_text' => 'required|max:255'
        ];
    }
}
