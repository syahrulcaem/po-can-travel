<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bus_id' => 'required|exists:buses,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'bus_id.required' => 'Bus harus dipilih.',
            'bus_id.exists' => 'Bus tidak ditemukan.',
            'rating.required' => 'Rating harus diisi.',
            'rating.min' => 'Rating minimal 1.',
            'rating.max' => 'Rating maksimal 5.',
            'comment.max' => 'Komentar maksimal 1000 karakter.',
        ];
    }
}
