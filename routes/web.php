<?php

use Illuminate\Support\Facades\Route;

// Datasets Mock untuk visualisasi data
$categories = [
    ['id' => 1, 'name' => 'Penjualan Produk', 'type' => 'income', 'description' => 'Hasil penjualan barang dagangan UMKM'],
    ['id' => 2, 'name' => 'Pendapatan Jasa', 'type' => 'income', 'description' => 'Pendapatan dari layanan/reparasi/layanan lainnya'],
    ['id' => 3, 'name' => 'Bahan Baku', 'type' => 'expense', 'description' => 'Pembelian bahan mentah kopi, gula, kemasan, dll'],
    ['id' => 4, 'name' => 'Gaji Karyawan', 'type' => 'expense', 'description' => 'Beban gaji staf operasional bulanan'],
    ['id' => 5, 'name' => 'Operasional Toko', 'type' => 'expense', 'description' => 'Listrik, air, sewa tempat, internet, dll'],
];

$products = [
    [
        'id' => 1, 
        'name' => 'Kopi Arabika Lintong 250gr', 
        'price' => 85000, 
        'stock' => 15, 
        'category_name' => 'Minuman', 
        'category' => ['name' => 'Minuman'],
        'description' => 'Biji kopi arabika pilihan dari daerah Lintong, Sumatera Utara. Memiliki rasa strong woody dan aroma rempah khas.'
    ],
    [
        'id' => 2, 
        'name' => 'Kopi Robusta Temanggung 250gr', 
        'price' => 45000, 
        'stock' => 8, 
        'category_name' => 'Minuman',
        'category' => ['name' => 'Minuman'],
        'description' => 'Kopi robusta Temanggung bercita rasa nutty dan chocolatey. Sangat cocok untuk kopi susu kekinian.'
    ],
    [
        'id' => 3, 
        'name' => 'Gula Pasir Kristal Putih 1kg', 
        'price' => 18000, 
        'stock' => 0, 
        'category_name' => 'Bahan Baku',
        'category' => ['name' => 'Bahan Baku'],
        'description' => 'Gula pasir kristal premium berkualitas tinggi sebagai bahan pemanis utama.'
    ],
    [
        'id' => 4, 
        'name' => 'Susu UHT Full Cream 1L', 
        'price' => 21000, 
        'stock' => 32, 
        'category_name' => 'Bahan Baku',
        'category' => ['name' => 'Bahan Baku'],
        'description' => 'Susu cair UHT berkualitas tinggi untuk campuran latte, cappucino, dan minuman kopi susu.'
    ],
];

$transactions = [
    ['id' => 1, 'date' => '2026-06-17 09:30:00', 'description' => 'Penjualan Kopi Arabika Lintong', 'type' => 'income', 'amount' => 170000, 'category_id' => 1, 'category' => ['name' => 'Penjualan Produk']],
    ['id' => 2, 'date' => '2026-06-17 10:15:00', 'description' => 'Pembelian Susu UHT 2 Karton', 'type' => 'expense', 'amount' => 504000, 'category_id' => 3, 'category' => ['name' => 'Bahan Baku']],
    ['id' => 3, 'date' => '2026-06-16 14:00:00', 'description' => 'Penerimaan Pelunasan Piutang Warung Bu Ani', 'type' => 'income', 'amount' => 2150000, 'category_id' => 2, 'category' => ['name' => 'Pendapatan Jasa']],
    ['id' => 4, 'date' => '2026-06-15 17:30:00', 'description' => 'Bayar Tagihan Listrik Toko', 'type' => 'expense', 'amount' => 850000, 'category_id' => 5, 'category' => ['name' => 'Operasional Toko']],
    ['id' => 5, 'date' => '2026-06-14 11:00:00', 'description' => 'Penjualan Kopi & Roti Bakar', 'type' => 'income', 'amount' => 320000, 'category_id' => 1, 'category' => ['name' => 'Penjualan Produk']],
];

$users = [
    ['id' => 1, 'name' => 'Admin Keuangan', 'email' => 'admin@finbiz.com', 'role' => 'admin', 'created_at' => '2026-01-10 10:00:00'],
    ['id' => 2, 'name' => 'Staf Kasir 1', 'email' => 'kasir@finbiz.com', 'role' => 'staff', 'created_at' => '2026-02-15 08:30:00'],
];

// RUTE AUTENTIKASI (AUTH)
Route::get('/', function () {
    return view('auth.login');
})->name('auth.login');

Route::get('/register', function () {
    return view('auth.register');
})->name('auth.register');


// GRUP RUTE ADMIN (ADMIN PANEL)
Route::prefix('admin')->name('admin.')->group(function () use ($categories, $products, $transactions, $users) {
    
    // Dashboard Admin
    Route::get('/dashboard', function () use ($transactions) {
        return view('admin.dashboard', [
            'recent_transactions' => array_slice($transactions, 0, 3)
        ]);
    })->name('dashboard');

    // Manajemen Transaksi Admin
    Route::get('/transactions', function () use ($transactions, $categories) {
        return view('admin.transactions.index', [
            'transactions' => $transactions,
            'categories' => $categories
        ]);
    })->name('transactions.index');

    Route::get('/transactions/create', function () use ($categories) {
        return view('admin.transactions.form', [
            'categories' => $categories
        ]);
    })->name('transactions.create');

    Route::get('/transactions/{id}/edit', function ($id) use ($transactions, $categories) {
        $transaction = collect($transactions)->firstWhere('id', (int)$id) ?? $transactions[0];
        return view('admin.transactions.form', [
            'transaction' => $transaction,
            'categories' => $categories
        ]);
    })->name('transactions.edit');

    // Laporan Keuangan Admin
    Route::get('/reports/profit-loss', function () {
        return view('admin.reports.profit-loss');
    })->name('reports.profit-loss');

    Route::get('/reports/cash-flow', function () {
        return view('admin.reports.cash-flow');
    })->name('reports.cash-flow');

    Route::get('/reports/receivables', function () {
        return view('admin.reports.receivables');
    })->name('reports.receivables');

    // Manajemen Pengguna Admin
    Route::get('/users', function () use ($users) {
        return view('admin.users.index', ['users' => $users]);
    })->name('users.index');

    Route::get('/users/create', function () {
        return view('admin.users.form');
    })->name('users.create');

    Route::get('/users/{id}/edit', function ($id) use ($users) {
        $user = collect($users)->firstWhere('id', (int)$id) ?? $users[0];
        return view('admin.users.form', ['user' => $user]);
    })->name('users.edit');

    // Manajemen Produk Admin
    Route::get('/products', function () use ($products) {
        return view('admin.products.index', ['products' => $products]);
    })->name('products.index');

    Route::get('/products/create', function () {
        return view('admin.products.form');
    })->name('products.create');

    Route::get('/products/{id}/edit', function ($id) use ($products) {
        $product = collect($products)->firstWhere('id', (int)$id) ?? $products[0];
        return view('admin.products.form', ['product' => $product]);
    })->name('products.edit');

    // Manajemen Kategori Admin
    Route::get('/categories', function () use ($categories) {
        return view('admin.categories.index', ['categories' => $categories]);
    })->name('categories.index');

    Route::get('/categories/create', function () {
        return view('admin.categories.form');
    })->name('categories.create');

    Route::get('/categories/{id}/edit', function ($id) use ($categories) {
        $category = collect($categories)->firstWhere('id', (int)$id) ?? $categories[0];
        return view('admin.categories.form', ['category' => $category]);
    })->name('categories.edit');
});


// GRUP RUTE NON-ADMIN (STAFF / KASIR)
Route::prefix('staff')->name('nonadmin.')->group(function () use ($categories, $products, $transactions) {
    
    // Dashboard Kasir
    Route::get('/dashboard', function () use ($transactions, $products) {
        $sales = array_filter($transactions, fn($t) => $t['type'] === 'income');
        return view('nonadmin.dashboard', [
            'recent_sales' => array_slice($sales, 0, 3),
            'popular_products' => array_slice($products, 0, 3),
        ]);
    })->name('dashboard');

    // Input Transaksi Kasir
    Route::get('/transactions/create', function () use ($categories) {
        return view('nonadmin.transactions.create', ['categories' => $categories]);
    })->name('transactions.create');

    // Riwayat Transaksi Kasir
    Route::get('/transactions/history', function () use ($transactions) {
        $sales = array_filter($transactions, fn($t) => $t['type'] === 'income');
        return view('nonadmin.transactions.history', [
            'sales_history' => $sales
        ]);
    })->name('transactions.history');

    // Katalog Produk Kasir
    Route::get('/products', function () use ($products) {
        return view('nonadmin.products.index', ['products' => $products]);
    })->name('products.index');

    Route::get('/products/{id}', function ($id) use ($products) {
        $product = collect($products)->firstWhere('id', (int)$id) ?? $products[0];
        return view('nonadmin.products.show', ['product' => $product]);
    })->name('products.show');

    // Laporan Harian Kasir
    Route::get('/reports/daily', function () {
        return view('nonadmin.reports.daily');
    })->name('reports.daily');
});
