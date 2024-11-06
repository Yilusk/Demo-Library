<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'isbn' => ['required','string','max:13'],
            'title' => ['required','string','max:200'],
            'description' => ['required','string'],
            'publisher' => ['required','string','max:100'],
            'release_date' => ['required','date'],
            'pages' => ['required','numeric'],
            'language' => ['required','string'],
            'volumen' => ['required','numeric'],
            'image' => ['nullable','file','mimes:jpg,jpeg,png'],
            'authors' => ['nullable','array'],
            'categories' => ['nullable','array'],
        ];
    }
}
