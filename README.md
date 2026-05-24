# SafePass - Secure Password Manager

SafePass adalah aplikasi password manager berbasis web yang menggunakan client-side encryption dengan AES-GCM dan PBKDF2 untuk menjaga keamanan data pengguna.

---

# Requirements

Sebelum menjalankan aplikasi, pastikan software berikut sudah terinstall:

## Software Wajib

* XAMPP / Laragon
* PHP 8.0+
* MySQL / MariaDB
* Apache Server
* Composer
* Web Browser modern (Chrome, Edge, Firefox)

---

# Dependensi yang Digunakan

## Frontend

* HTML5
* CSS3
* JavaScript
* Bootstrap 5
* Web Crypto API

## Backend

* PHP Native
* MySQL
* Composer

---

# Cara Install & Menjalankan Aplikasi

## 1. Clone / Download Project

Clone repository:

```bash
git clone https://github.com/naulla/safepass2.git
```

Masuk ke folder project:

```bash
cd safepass2
```

Atau download ZIP project lalu extract.

---

## 2. Pindahkan Folder Project

Pindahkan folder project ke:

### XAMPP

```bash
C:\xampp\htdocs\
```

### Laragon

```bash
C:\laragon\www\
```

Contoh hasil:

```bash
C:\xampp\htdocs\safepass2
```

---

## 3. Install Dependency Composer

Buka terminal / CMD pada folder project lalu jalankan:

```bash
composer install
```

Tunggu hingga folder `vendor/` berhasil dibuat.

---

## 4. Jalankan Apache & MySQL

Buka XAMPP Control Panel lalu aktifkan:

* Apache
* MySQL

---

# 5. Buat Database

Buka browser:

```bash
http://localhost/phpmyadmin
```

Lalu:

1. Klik **New**
2. Buat database baru dengan nama:

```sql
safepass2
```

---

# 6. Import Database

Import file SQL yang ada pada folder:

```bash
database/safepass2.sql
```

Langkah:

1. Klik database `safepass2`
2. Pilih menu **Import**
3. Klik **Choose File**
4. Pilih `safepass2.sql`
5. Klik **Go**

---

# Konfigurasi Database

Buka file:

```bash
config/database.php
```

Sesuaikan konfigurasi berikut:

```php
<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "safepass2";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Koneksi database gagal");
}
?>
```

---

# Menjalankan Aplikasi

Buka browser lalu akses:

```bash
http://localhost/safepass2
```

Jika berhasil maka halaman login SafePass akan muncul.

---

# Struktur Folder Project

```bash
SAFEPASS2/
│
├── api/
│   ├── delete_vault.php
│   ├── get_login_data.php
│   ├── get_single_vault.php
│   ├── get_vault.php
│   ├── import_backup.php
│   ├── login.php
│   ├── register.php
│   ├── save_vault.php
│   ├── update_vault.php
│   └── verify_login.php
│
├── assets/
│   ├── css/
│   │   └── style.css
│   │
│   └── js/
│       ├── add.js
│       ├── auth-check.js
│       ├── auth.js
│       ├── auto-logout.js
│       ├── backup.js
│       ├── crypto.js
│       ├── dashboard.js
│       ├── edit.js
│       ├── generator.js
│       ├── login.js
│       ├── password-checker.js
│       ├── vault-api.js
│       └── vault-ui.js
│
├── config/
│   ├── database.php
│   └── session.php
│
├── database/
│   └── safepass2.sql
│
├── vendor/
│
├── .htaccess
├── composer.json
├── composer.lock
├── index.php
└── README.md
```

---

# Fitur Aplikasi

* Register & Login
* Password Vault
* AES-GCM Encryption
* PBKDF2 Key Derivation
* Password Generator
* Password Strength Checker
* Copy Password
* Backup & Restore
* Auto Logout Session
* Session Management
* Responsive Design

---

# Cara Kerja Singkat

1. User login menggunakan master password
2. Browser menghasilkan encryption key menggunakan PBKDF2
3. Data password dienkripsi dengan AES-GCM
4. Database hanya menyimpan ciphertext
5. Password didekripsi langsung di browser pengguna

---

# Catatan Keamanan

* Jangan gunakan master password yang lemah
* Simpan backup vault dengan aman
* Gunakan browser modern yang mendukung Web Crypto API
* Project ini masih berjalan di localhost dan belum production-ready

---

# Pengembangan Selanjutnya

* HTTPS Deployment
* Two-Factor Authentication (2FA)
* Rate Limiting
* CSP Security
* Multi-device Sync
* Cloud Backup Encryption

---

# Author

SafePass Password Manager

Developed by:

* Dani Hidayat (2488010016)
* Naula Alfiyatul Fauziyyah (2488010063)
* Alfiah Lutfi Sabilah (2488010032)

Project dibuat untuk kebutuhan pembelajaran dan penelitian keamanan aplikasi web.