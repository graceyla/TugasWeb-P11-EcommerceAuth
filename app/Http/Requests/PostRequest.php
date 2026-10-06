<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Hak akses dicek di controller pakai PostPolicy,
     * di sini cuma validasi input.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:150'],
            'body' => ['required', 'string', 'min:20'],
            'is_published' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute minimal :min karakter.',
            'max' => ':attribute maksimal :max karakter.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Judul',
            'body' => 'Isi artikel',
        ];
    }

    protected function prepareForValidation(): void
    {
        // checkbox yang ga dicentang ga ikut terkirim, jadi diisi false manual
        $this->merge(['is_published' => $this->boolean('is_published')]);
    }
}
