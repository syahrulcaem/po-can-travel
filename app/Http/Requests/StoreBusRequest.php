<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Will be handled by middleware
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:20|unique:buses,plate_number',
            'capacity' => 'required|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama bus harus diisi.',
            'plate_number.required' => 'Nomor plat harus diisi.',
            'plate_number.unique' => 'Nomor plat sudah terdaftar.',
            'capacity.required' => 'Kapasitas bus harus diisi.',
            'capacity.min' => 'Kapasitas bus minimal 1.',
            'capacity.max' => 'Kapasitas bus maksimal 100.',
        ];
    }
}
