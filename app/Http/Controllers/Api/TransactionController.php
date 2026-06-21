<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\transactionRequest;
use App\Models\Transaction;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all();

        if ($transactions->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Belum ada transaksi',
                'data' => [],
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data transaksi berhasil diambil',
            'data' => $transactions,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(transactionRequest $request)
    {
        $validated = $request->validated();

        $transaction = Transaction::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil ditambahkan',
            'data' => $transaction,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data transaksi berhasil diambil',
            'data' => $transaction,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(transactionRequest $request, string $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan',
            ], 404);
        }

        $validated = $request->validated();

        $transaction->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil diupdate',
            'data' => $transaction,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan',
            ], 404);
        }

        $transaction->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil dihapus',
        ], 200);
    }
}
