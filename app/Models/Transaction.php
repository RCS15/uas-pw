<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['tanggal', 'jenis_transaksi', 'description', 'total_harga', 'user_id', 'product_id'])]
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
     * Produk utama yang terkait transaksi ini (boleh kosong untuk expense non-produk).
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Seluruh baris rincian produk dalam transaksi ini (jika transaksi memuat banyak produk).
     */
    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }
}