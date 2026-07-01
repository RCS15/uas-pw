# FinBiz - POS & Financial Management System

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)

**FinBiz** adalah aplikasi Point of Sales (POS) dan manajemen keuangan terintegrasi yang dirancang untuk mendukung operasional bisnis retail dan UMKM. Sistem ini mengelola seluruh siklus transaksi mulai dari manajemen stok hingga pelaporan laba rugi otomatis.

---

## 🌟 Fitur Utama

### 🔐 Multi-Role Access Control
Sistem mendukung dua level akses utama dengan otorisasi yang ketat:
*   **Administrator:** Akses penuh ke manajemen data master (Product, Category, User) dan laporan keuangan strategis.
*   **Non-Admin/Kasir:** Fokus pada operasional harian seperti input transaksi penjualan, pengecekan stok katalog, dan pengelolaan nota belanja.

### 💰 Manajemen Transaksi & Keuangan
*   **Input Penjualan Multi-Item:** Mendukung penambahan banyak produk dalam satu nota tunggal.
*   **Auto-Update Stok:** Stok produk berkurang secara otomatis setiap kali terjadi transaksi penjualan.
*   **Laporan Laba Rugi:** Perhitungan otomatis berdasarkan data transaksi 'Income' dan 'Expense'.
*   **Struk A5 Native:** Fitur cetak nota dengan tata letak A5 yang presisi dan fitur *auto-redirect* setelah proses cetak selesai.

### 📦 Manajemen Inventaris
*   Katalog produk real-time dengan informasi sisa stok.
*   Pengelompokan barang berdasarkan kategori untuk kemudahan pencarian.

---

## 🛠️ Arsitektur & Teknologi

### Tech Stack
*   **Framework:** Laravel 11.x (PHP 8.3+)
*   **Styling:** Tailwind CSS (Modern UI)
*   **Database:** MySQL
*   **Reporting:** DomPDF & Native Browser Printing

### Skema Database Utama
Sistem ini menggunakan struktur database relasional yang kuat:
*   `users`: Menyimpan data kredensial dan peran (admin/nonadmin).
*   `categories`: Pengelompokan jenis produk.
*   `products`: Data teknis barang (nama, harga beli/jual, stok).
*   `transactions`: Tabel Master untuk merekam total belanja, jenis transaksi, dan kasir penanggung jawab.
*   `transaction_details`: Tabel Detail untuk merekam item-item produk spesifik dalam satu transaksi.

---

## 🖥️ Instalasi Sistem

### Prasyarat
*   PHP ^8.3
*   Composer ^2.x
*   Node.js & npm
*   MySQL Server

### Langkah-langkah
1.  **Clone Repository**
    ```bash
    git clone https://github.com/RCS15/uas-pw.git
    cd uas-pw
    ```

2.  **Instalasi Dependency**
    ```bash
    composer install
    npm install
    ```

3.  **Pengaturan Environment**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Sesuaikan variabel `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di file `.env`.*

4.  **Inisialisasi Database**
    ```bash
    php artisan migrate --seed
    ```

5.  **Menjalankan Aplikasi**
    ```bash
    npm run dev
    # Buka terminal baru
    php artisan serve
    ```

---

## 🔑 Kredensial Akses (Default)

| Role | Email | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin@gmail.com` | `password` |
| **Kasir / Staf** | `nonadmin@gmail.com` | `password` |

---

## 📂 Struktur Penting Proyek
*   `app/Http/Controllers/Admin`: Logika manajemen data master.
*   `app/Http/Controllers/NonAdmin`: Logika operasional kasir.
*   `resources/views/nonadmin/transactions/print.blade.php`: Template struk A5.
*   `database/migrations`: Definisi struktur tabel.

---

## 📝 Informasi Tambahan
Aplikasi ini dikembangkan sebagai syarat pemenuhan tugas **UAS Pemrograman Web**. Kode bersifat open-source untuk tujuan pembelajaran.

**© 2026 Proyek FinBiz**
