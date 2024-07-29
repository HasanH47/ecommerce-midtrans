# Aplikasi E-Commerce Laravel

Ini adalah aplikasi E-Commerce berbasis Laravel yang memungkinkan pengguna untuk menjelajahi produk, menambahkannya ke keranjang, dan melakukan pembayaran menggunakan Midtrans. Admin dapat mengelola produk melalui panel admin.

## Fitur

-   Autentikasi Pengguna
-   Manajemen Produk (Admin)
-   Keranjang Belanja
-   Proses Checkout dengan Midtrans Payment Gateway
-   Manajemen Pesanan
-   Desain Responsif

## Instalasi

### Langkah-langkah

1. Clone repositori:

    ```bash
    git clone https://github.com/HasanH47/ecommerce-midtrans.git
    cd ecommerce-midtrans
    ```

2. Install dependencies:

    ```bash
    composer install
    npm install
    ```

3. Salin file `.env.example` menjadi `.env` dan konfigurasi variabel lingkungan Anda:

    ```bash
    cp .env.example .env
    ```

    atau

    ```bash
    copy .env.example .env
    ```

4. Tambahkan konfigurasi Midtrans ke file `.env`:

    ```env
    MIDTRANS_SERVER_KEY=your_midtrans_server_key
    MIDTRANS_CLIENT_KEY=your_midtrans_client_key
    MIDTRANS_IS_PRODUCTION=false
    MIDTRANS_IS_SANITIZED=true
    MIDTRANS_IS_3DS=true
    ```

5. Generate kunci aplikasi:

    ```bash
    php artisan key:generate
    ```

6. Jalankan migrasi:

    ```bash
    php artisan migrate
    ```

7. Jalankan seeder database untuk membuat akun:

    ```bash
    php artisan db:seed
    ```

8. Kompilasi aset frontend:

    ```bash
    npm run dev
    ```

    atau

    ```bash
    npm run build
    ```

9. Mulai server pengembangan:

    ```bash
    php artisan serve
    ```

## Penggunaan

### Pengguna

-   Daftar dan masuk ke akun Anda.
-   Jelajahi produk dan tambahkan ke keranjang Anda.
-   Lanjutkan ke checkout dan lakukan pembayaran melalui Midtrans.
-   Lihat riwayat dan detail pesanan.

### Admin

-   Masuk dengan akun admin yang dibuat selama seeding.
-   Kelola produk (operasi CRUD).

### Akun Akses

-   Admin: `admin@example.com` | Password: `password`
-   User: `user@example.com` | Password: `password`

## Lisensi

Proyek ini dilisensikan di bawah Lisensi MIT - lihat file [LICENSE](LICENSE) untuk detail.
