<?php

namespace App\Http\Requests\api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class transactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return  true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tanggal' => 'required',
            'user_id' => 'required|exists:users,id',
            'jenis_transaksi' => 'required|in:income,expense',
            'deskripsi' => 'nullable|string',
            'total_harga' => 'required|decimal:2|min:0',
        ];
    }

    // public function messages()
    // {
    //     return response()->json([
    //         'status' => 'error',
    //         'message' => 'Transaksi gagal ditambahkan',
    //         'data' => null,
    //     ], 400);
    // }
}
