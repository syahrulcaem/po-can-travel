<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
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
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date|after:now',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'bus_id.required' => 'Bus harus dipilih.',
            'bus_id.exists' => 'Bus tidak ditemukan.',
            'route_id.required' => 'Rute harus dipilih.',
            'route_id.exists' => 'Rute tidak ditemukan.',
            'departure_time.required' => 'Waktu keberangkatan harus diisi.',
            'departure_time.after' => 'Waktu keberangkatan harus setelah sekarang.',
            'arrival_time.required' => 'Waktu kedatangan harus diisi.',
            'arrival_time.after' => 'Waktu kedatangan harus setelah waktu keberangkatan.',
            'price.required' => 'Harga tiket harus diisi.',
            'price.min' => 'Harga tiket tidak boleh negatif.',
        ];
    }
}
