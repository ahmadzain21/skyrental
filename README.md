# Skyrental

Aplikasi manajemen penyewaan iPhone berbasis web.  
User dapat mencari dan menemukan iPhone yang tersedia berdasarkan tanggal yang diinginkan, melakukan booking, dan melanjutkan ke pembayaran.  
Dibangun menggunakan **Laravel 12**, **Livewire 3**, dan **Alpine.js** untuk pengalaman interaktif tanpa reload halaman.

---

## Fitur Utama
- **Cari & Temukan iPhone** berdasarkan tanggal sewa
- **Autentikasi User** (registrasi & login)
- **Booking & Manajemen Sewa**
- **Sistem Pembayaran** (dapat dikembangkan untuk gateway seperti Midtrans atau manual transfer)

---

## Teknologi yang Digunakan
- [Laravel 12](https://laravel.com/) (Backend Framework)
- [Livewire 3](https://livewire.laravel.com/) (Full-stack interactivity)
- [Alpine.js](https://alpinejs.dev/) (Reactive frontend)
- [TailwindCSS](https://tailwindcss.com/) (Styling)
- Database: **SQLite (default)** atau **MySQL**

---

## nstalasi & Setup

1. Clone repository
   ```bash
   git clone https://github.com/joisv/skyrent.git
   cd sewa-iphone

2. Install dependensi
   ```bash
    composer install
    npm install && npm run dev  

3.Setup enviroment
    ```bash
    cp .env.example .env
    php artisan key:generate

4. Migrasi Database
    ```bash
    php artisan:migrate

5.jalankan serve

    ```bash 
    php artisan:serve
