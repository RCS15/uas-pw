<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['category_id', 'nama_barang', 'harga', 'stok'])]
class Product extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'stok' => 'integer',
        ];
    }

    /**
     * Kategori dari produk ini.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Transaksi yang merujuk langsung ke produk ini (kolom transactions.product_id).
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Seluruh baris detail transaksi yang memuat produk ini.
     */
    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'product_id');
    }

    /**
     * Scope untuk pencarian dan filter produk
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        // Filter berdasarkan pencarian nama produk
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nama_barang', 'like', '%'.$search.'%');
        });

        // Filter berdasarkan kategori menggunakan relasi
        $query->when($filters['category_id'] ?? null, function ($query, $id) {
            $query->whereHas('category', function ($q) use ($id) {
                // Mencari di tabel 'categories' pada kolom 'id'
                $q->where('id', $id);
            });
        });
    }
}
