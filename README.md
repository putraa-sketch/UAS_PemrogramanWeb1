# UAS Pemrograman Web 1

## Informasi
- **Nama**: Abdi Putra Perdana
- **NIM**: 312410426
- **Kelas**: TI 24 A3
- **Mata Kuliah**: Pemrograman Web 1

# Sistem Informasi Manajemen Data Barang (MVC)

## Deskripsi Project
Aplikasi ini adalah **Sistem Inventaris Barang** yang dibangun menggunakan bahasa pemrograman **PHP Native** dengan paradigma **OOP (Object Oriented Programming)** dan arsitektur **MVC (Model-View-Controller)**.

Aplikasi ini dirancang untuk memisahkan logika bisnis (Controller), data (Model), dan tampilan (View) agar kode lebih rapi, terstruktur, dan mudah dikembangkan (maintainable).

## Fitur Utama
1.  **Sistem Login & Logout**: Keamanan akses menggunakan Session dan Password Hashing (`password_verify`).
2.  **Dashboard**: Menampilkan ringkasan data barang.
3.  **CRUD Barang**:
    * **Create**: Menambah data barang baru beserta upload gambar.
    * **Read**: Menampilkan daftar barang dengan pagination dan pencarian (search).
    * **Update**: Mengedit data barang dan mengganti gambar produk.
    * **Delete**: Menghapus data barang beserta filenya dari server.
4.  **Routing System**: URL yang bersih (Clean URL) menggunakan `.htaccess` dan `App Core`.
5.  **Desain Responsif**: Menggunakan framework CSS **Bootstrap 5**.

## Struktur Direktori (MVC)
Berikut adalah struktur folder project ini:
```
PROJECT_UAS_WEB/
├── app/
│   ├── Config/
│   │   ├── Config.php          
│   │   └── Database.php         
│   ├── Controllers/
│   │   ├── AuthController.php   
│   │   ├── BarangController.php 
│   │   └── HomeController.php  
│   ├── Core/
│   │   ├── App.php              
│   │   ├── Controller.php      
│   │   ├── Flash.php            
│   │   └── Form.php            
│   ├── Models/
│   │   ├── ProductModel.php     
│   │   └── UserModel.php       
│   └── Views/
│       ├── admin/
│       │   ├── dashboard.php   
│       │   ├── form.php         
│       │   └── stats.php       
│       ├── auth/
│       │   └── login.php       
│       ├── barang/
│       │   ├── form.php         
│       │   └── index.php       
│       ├── home/
│       │   └── index.php      
│       └── templates/
│           ├── footer.php      
│           ├── header.php       
│           └── sidebar.php     
├── public/
│   ├── css/                     
│   ├── gambar/                  
│   ├── .htaccess                
│   ├── cek_login_manual.php     
│   ├── index.php                
│   └── test_session.php         
└── README.md                       
```

## Teknologi yang Digunakan
* **Backend**: PHP 8.x (OOP & MVC Pattern)
* **Database**: MySQL / MariaDB
* **Frontend**: HTML5, CSS3, Bootstrap 5.3
* **Tools**: VS Code, XAMPP, Browser

---

## Screenshot Aplikasi

Berikut adalah dokumentasi tampilan dan fungsionalitas sistem:

### 1. Halaman Login
Halaman masuk untuk administrator dengan validasi username dan password.
*(Ganti teks ini dengan gambar screenshot login)*
`![Halaman Login](screenshots/login.png)`

### 2. Dashboard Admin
Halaman utama setelah login yang menampilkan statistik data.
*(Ganti teks ini dengan gambar screenshot dashboard)*
`![Dashboard](screenshots/dashboard.png)`

### 3. Data Barang (List)
Menampilkan tabel data barang dengan fitur Pagination dan Pencarian.
*(Ganti teks ini dengan gambar screenshot tabel barang)*
`![Data Barang](screenshots/list_barang.png)`

### 4. Tambah Barang (Create)
Form input data barang baru dengan fitur upload gambar.
*(Ganti teks ini dengan gambar screenshot form tambah)*
`![Tambah Barang](screenshots/tambah_barang.png)`

### 5. Edit Barang (Update)
Form untuk mengubah data barang yang sudah ada.
*(Ganti teks ini dengan gambar screenshot form edit)*
`![Edit Barang](screenshots/edit_barang.png)`

---

## Demo Aplikasi (Video)

Untuk melihat demonstrasi lengkap penggunaan aplikasi, silakan kunjungi link YouTube berikut:

**Link Video:** [Klik Disini untuk Menonton](LINK_YOUTUBE_ANDA)

---

## Cara Instalasi & Menjalankan

1.  **Clone / Download** repository ini.
2.  Pindahkan folder ke dalam direktori `htdocs` (misal: `C:\xampp\htdocs\PROJECT_UAS_WEB`).
3.  **Setup Database**:
    * Buka phpMyAdmin.
    * Buat database bernama `latihan1`.
    * Import file `database.sql` (atau buat tabel `users_uas` dan `data_barang`).
4.  **Konfigurasi**:
    * Buka `app/Config/Config.php`.
    * Sesuaikan `BASE_URL` dan `DB_NAME`.
5.  **Akses**:
    * Buka browser dan ketik: `http://localhost/PROJECT_UAS_WEB/public/`

---
© 2026 Universitas Pelita Bangsa
