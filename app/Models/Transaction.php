<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['tanggal', 'jenis_transaksi', 'deskripsi', 'total_harga', 'user_id', 'tipe_transaksi'])]
class Transaction extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'total_harga' => 'decimal:2',
        ];
    }

    /**
     * User (admin/staf) yang mencatat transaksi ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Seluruh baris rincian produk dalam transaksi ini (jika transaksi memuat banyak produk).
     */
    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope untuk memfilter berdasarkan kata kunci keterangan
     */
    public function scopeFilterSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function ($q) use ($search) {
            // Kita bungkus dalam where closure agar logika 'OR' tidak merusak filter lain (seperti jenis_transaksi)
            $q->where(function ($innerQuery) use ($search) {
                $innerQuery->where('deskripsi', 'like', '%'.$search.'%')

                           // Tambahan: Cari berdasarkan nama di tabel users
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%'.$search.'%');
                    });
            });
        });
    }

    /**
     * Scope untuk memfilter berdasarkan tipe (income/expense)
     */
    public function scopeFilterType(Builder $query, ?string $type): Builder
    {
        return $query->when($type, function ($q) use ($type) {
            $q->where('jenis_transaksi', $type);
        });
    }

    public function scopeFilterTransactionType(Builder $query, ?string $transactionType)
    {
        // return $query->where('transaction_type', $transactiontype);
        return $query->when($transactionType, function ($q) use ($transactionType) {
            $q->where('tipe_transaksi', $transactionType);
        });
    }

    
}
