# FinBiz - POS & Financial Management System

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)

**FinBiz** adalah aplikasi Point of Sales (POS) dan manajemen keuangan sederhana yang dirancang untuk membantu UMKM atau bisnis retail dalam mengelola transaksi penjualan, stok barang, dan laporan keuangan secara efisien.

---

## 🚀 Fitur Utama

### 👨‍💼 Panel Admin
*   **Dashboard Statis & Dinamis:** Ringkasan performa bisnis.
*   **Manajemen Produk:** CRUD (Create, Read, Update, Delete) data barang beserta kategori.
*   **Manajemen Pengguna:** Pengaturan akun petugas/kasir.
*   **Laporan Keuangan:** Laporan laba rugi dan arus kas terperinci.
*   **Riwayat Transaksi:** Memantau seluruh transaksi yang terjadi di sistem.

### 🧑‍💻 Panel Kasir (Non-Admin)
*   **Input Penjualan:** Antarmuka input transaksi yang cepat dan mudah.
*   **Riwayat Penjualan Anda:** Melihat catatan penjualan pribadi selama shift bertugas.
*   **Cetak Struk:** Fitur cetak nota belanja format A5 otomatis.
*   **Katalog Produk:** Mencari dan melihat informasi stok produk secara real-time.
*   **Laporan Harian:** Ringkasan performa penjualan harian kasir.

---

## 🛠️ Teknologi yang Digunakan

*   **Framework:** Laravel (v13)
*   **Database:** MySQL
*   **Frontend Styling:** Tailwind CSS
*   **PDF/Print Engine:** HTML5 Print & DomPDF (untuk laporan)
*   **Server Environment:** Laragon / XAMPP

---

## 💻 Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan project di komputer Anda:

1.  **Clone Repository**
    ```bash
    git clone https://github.com/username/uas-pw.git
    cd uas-pw
    ```

2.  **Instalasi Dependency**
    ```bash
    composer install
    npm install
    ```

3.  **Pengaturan Environment**
    Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Migrasi & Seeding**
    Buat database baru di MySQL, lalu jalankan:
    ```bash
    php artisan migrate --seed
    ```

5.  **Jalankan Server**
    ```bash
    php artisan serve
    npm run dev
    ```

## 🔐 Akun Demo (Default)

| Role | Username / Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@gmail.com` | `password` |
| **Kasir** | `nonadmin@gmail.com` | `password` |

---

## 📝 Lisensi
Aplikasi ini dibuat sebagai bagian dari Tugas UAS Pemrograman Web. Seluruh kode bersifat open-source.

