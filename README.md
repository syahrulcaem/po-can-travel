# PO CAN Travel - Bus Booking System

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.0+-38B2AC.svg)](https://tailwindcss.com)

PO CAN Travel adalah platform pemesanan tiket bus yang efisien dan user-friendly. Platform ini memungkinkan pengguna untuk mencari, memilih, dan memesan tiket bus dengan mudah, serta menyediakan panel admin untuk mengelola sistem.

## 📋 Daftar Isi

-   [Fitur Utama](#-fitur-utama)
-   [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
-   [ERD Database](#-erd-database)
-   [Persyaratan Sistem](#-persyaratan-sistem)
-   [Instalasi](#-instalasi)
-   [Konfigurasi](#-konfigurasi)
-   [Menjalankan Aplikasi](#-menjalankan-aplikasi)
-   [Seeder & Demo Data](#-seeder--demo-data)
-   [Akun Default](#-akun-default)
-   [Fitur & Screenshots](#-fitur--screenshots)
-   [API Documentation](#-api-documentation)
-   [Testing](#-testing)
-   [Contributing](#-contributing)
-   [License](#-license)

## 🚀 Fitur Utama

### User Features

-   ✅ **Authentication System** - Register, Login, Logout dengan Laravel Breeze
-   ✅ **Search & Filter Tiket** - Pencarian berdasarkan rute, tanggal, dan harga
-   ✅ **Booking System** - Pemilihan kursi dan pemesanan tiket
-   ✅ **Payment Proof Upload** - Upload bukti pembayaran
-   ✅ **Order Management** - Lihat, batalkan pesanan
-   ✅ **Review System** - Rating dan review bus setelah perjalanan
-   ✅ **Profile Management** - Edit profil dan ganti password
-   ✅ **Responsive Design** - Support mobile dan desktop

### Admin Features

-   ✅ **Admin Dashboard** - Overview sistem dan statistik
-   ✅ **Bus Management** - CRUD buses dengan validasi
-   ✅ **Route Management** - CRUD rute perjalanan
-   ✅ **Schedule Management** - CRUD jadwal perjalanan
-   ✅ **Order Management** - Konfirmasi pembayaran dan kelola pesanan
-   ✅ **Payment Confirmation** - Verifikasi bukti pembayaran
-   ✅ **Multi-Guard Authentication** - Sistem auth terpisah untuk admin

### Advanced Features

-   ✅ **Real-time Seat Availability** - Cek kursi tersedia secara real-time
-   ✅ **File Upload System** - Storage management untuk bukti pembayaran
-   ✅ **Validation System** - Comprehensive input validation
-   ✅ **Flash Messages** - User feedback system
-   ✅ **Pagination** - Efficient data loading
-   ✅ **ERD Generator** - Command untuk generate ERD syntax

## 🛠 Teknologi yang Digunakan

-   **Backend**: Laravel 10.x
-   **Frontend**: Blade Templates + Tailwind CSS
-   **Database**: MySQL 8.0+
-   **File Storage**: Laravel Storage (Local/Public)
-   **Validation**: Form Request Classes
-   **ORM**: Eloquent ORM
-   **Icons**: Font Awesome
-   **CSS Framework**: Tailwind CSS

## 📊 ERD Database

Generate ERD syntax untuk visualisasi di dbdiagram.io:

```bash
php artisan generate:erd --output=erd.txt
```

Sistem menggunakan 8 tabel utama:

-   **users** - Data pengguna
-   **admins** - Data administrator
-   **buses** - Data bus
-   **routes** - Data rute perjalanan
-   **schedules** - Jadwal perjalanan
-   **orders** - Data pesanan (dengan payment_proof)
-   **tickets** - Data tiket
-   **reviews** - Review dan rating

## ⚙️ Persyaratan Sistem

-   PHP >= 8.1
-   Composer
-   MySQL >= 8.0
-   Node.js >= 16.x (untuk asset compilation)
-   Git

## 📦 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/your-username/po-can-travel.git
cd po-can-travel
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies (opsional)
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

```bash
# Create database (MySQL)
mysql -u root -p
CREATE DATABASE po_can_travel;
EXIT;
```

## 🔧 Konfigurasi

### 1. Database Configuration

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=po_can_travel
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 2. Storage Configuration

```bash
# Create storage link
php artisan storage:link
```

### 3. Run Migrations

```bash
# Run all migrations
php artisan migrate

# Run migrations with seeders
php artisan migrate --seed
```

## 🚀 Menjalankan Aplikasi

### Development Server

```bash
# Start Laravel server
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

### Production Setup

```bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🌱 Seeder & Demo Data

### Run All Seeders

```bash
php artisan db:seed
```

### Individual Seeders

```bash
php artisan db:seed --class=BusSeeder
php artisan db:seed --class=RouteSeeder
php artisan db:seed --class=ScheduleSeeder
```

### Fresh Migration with Seed

```bash
php artisan migrate:fresh --seed
```

## 👤 Akun Default

### Admin Account

-   **URL**: `/admin/login`
-   **Email**: admin@po-can-travel.com
-   **Password**: password123

### User Account

-   **URL**: `/login`
-   **Email**: user@example.com
-   **Password**: password123

## 📱 Fitur & Screenshots

### User Interface

-   **Homepage**: Landing page dengan search form
-   **Search Results**: List jadwal dengan filter
-   **Booking**: Seat selection dan form pemesanan
-   **My Tickets**: Kelola pesanan dan upload bukti pembayaran
-   **Reviews**: System rating dan komentar
-   **Profile**: Edit profil dan ganti password

### Admin Interface

-   **Dashboard**: Overview dan statistik
-   **Bus Management**: CRUD buses
-   **Route Management**: CRUD rute
-   **Schedule Management**: Kelola jadwal
-   **Payment Confirmation**: Verifikasi bukti pembayaran

## 📚 Command Artisan

### Generate ERD

```bash
php artisan generate:erd --output=erd.txt
```

### Migration Commands

```bash
php artisan migrate
php artisan migrate:fresh
php artisan migrate:rollback
```

### Seeder Commands

```bash
php artisan db:seed
php artisan db:seed --class=BusSeeder
```

## 🧪 Testing

### Manual Testing Flow

1. **User Registration/Login**
2. **Search & Book Tickets**
3. **Upload Payment Proof**
4. **Admin Payment Confirmation**
5. **Review System**

### Database Testing

```bash
# Check migrations
php artisan migrate:status

# Test seeders
php artisan db:seed --class=BusSeeder
```

## 📁 Struktur Project

```
po-can-travel/
├── app/
│   ├── Console/Commands/        # Custom Artisan commands
│   ├── Http/Controllers/        # Controllers (User & Admin)
│   ├── Http/Requests/          # Form Request validation
│   ├── Models/                 # Eloquent models
│   └── Providers/              # Service providers
├── database/
│   ├── migrations/             # Database migrations
│   ├── seeders/               # Database seeders
│   └── factories/             # Model factories
├── resources/
│   ├── views/                 # Blade templates
│   │   ├── admin/             # Admin views
│   │   ├── orders/            # Order views
│   │   ├── reviews/           # Review views
│   │   └── layouts/           # Layout templates
│   ├── css/                   # Stylesheets
│   └── js/                    # JavaScript files
├── routes/
│   ├── web.php                # Web routes
│   ├── api.php                # API routes
│   └── auth.php               # Auth routes
└── storage/
    └── app/public/            # Public file storage
```

## 🤝 Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Create Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**M. Syahrul Romadhon**

## 🆘 Troubleshooting

### Common Issues

1. **Storage Permission Error**

    ```bash
    chmod -R 775 storage bootstrap/cache
    ```

2. **Database Connection Error**

    - Check `.env` database configuration
    - Ensure MySQL service is running
    - Verify database exists

3. **Migration Error**

    ```bash
    php artisan migrate:fresh
    ```

4. **File Upload Error**
    ```bash
    php artisan storage:link
    ```

### Support

Jika mengalami masalah, silakan:

1. Check dokumentasi Laravel
2. Periksa log error di `storage/logs/laravel.log`
3. Contact: syahrulromadhonmuhammad@gmail.com

---

## 📝 Test Case Requirements Checklist

✅ **1. ERD Database Design** - Complete with relationships  
✅ **2. Laravel 10 System** - Login, Register, Order Tiket  
✅ **3. Additional Features** - Payment proof, Reviews, Admin panel  
✅ **4. Database Migrations** - All tables with proper structure  
✅ **5. Eloquent ORM & Validation** - Models, relationships, form validation  
✅ **6. GitHub Upload** - Ready for repository upload

**Submission Ready for CAN Creative Backend Intern Test Case** 🚀

⭐ **Star this repo if you find it helpful!**

**Built with ❤️ for CAN Creative Backend Intern Test Case**
