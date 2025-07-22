<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRouteRequest extends FormRequest
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
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255|different:origin',
            'distance' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'origin.required' => 'Kota asal harus diisi.',
            'destination.required' => 'Kota tujuan harus diisi.',
            'destination.different' => 'Kota tujuan harus berbeda dengan kota asal.',
            'distance.required' => 'Jarak harus diisi.',
            'distance.min' => 'Jarak minimal 1 km.',
        ];
    }
}
