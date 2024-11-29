<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateBookRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'key' => ['string', 'required'],
            'title' => ['string', 'required'],
            'authors' => ['json', 'required'],
            'cover_url' => ['string', 'nullable'],
            'tag1s' => ['string', 'nullable'],
            'tag2' => ['string', 'nullable'],
            'tag3' => ['string', 'nullable'],
            'tag4' => ['string', 'nullable'],
            'tag5' => ['string', 'nullable'],
            'is_read' => [Rule::in(['on']), 'nullable'],
            'is_owned' => [Rule::in(['on']), 'nullable'],
            'page_count' => ['string', 'nullable'],
        ];
    }
}
