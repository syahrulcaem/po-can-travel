<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'schedule_id' => 'required|exists:schedules,id',
            'tickets' => 'required|array|min:1',
            'tickets.*.seat_number' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'schedule_id.required' => 'Jadwal harus dipilih.',
            'schedule_id.exists' => 'Jadwal tidak ditemukan.',
            'tickets.required' => 'Minimal satu tiket harus dipilih.',
            'tickets.*.seat_number.required' => 'Nomor kursi harus diisi.',
        ];
    }
}
