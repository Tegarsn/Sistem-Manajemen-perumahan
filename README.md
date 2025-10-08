# 🏠 Sistem Manajemen Perumahan

Sistem Manajemen Perumahan adalah aplikasi berbasis web yang digunakan untuk mengelola data pembangunan rumah, bahan bangunan, customer, transaksi, serta manajemen user.  
Proyek ini dibangun menggunakan **CodeIgniter 4** dan **MySQL** sebagai database utama.

---

## 🚀 Fitur Utama

- **Manajemen Data Bahan Bangunan**  
  Tambah, edit, hapus, dan lihat stok bahan secara real-time dengan integrasi DataTables dan AJAX.

- **Manajemen Pembelian Bahan**  
  Setiap pembelian bahan akan otomatis menambah stok di tabel bahan bangunan.

- **Manajemen Data Customer**  
  CRUD data customer lengkap dengan form modal dan pemrosesan server-side DataTables.

- **Manajemen Pembangunan Rumah**  
  Pantau progres pembangunan, realisasi bahan, serta pekerja yang terlibat.

- **Transaksi Pembelian Rumah**  
  Saat rumah terjual, status otomatis berubah menjadi *terjual* di data perumahan.

- **Dashboard Interaktif**  
  Menampilkan ringkasan data penting (grafik, kartu informasi, dan statistik proyek).

- **Manajemen User & Role**  
  Pengaturan hak akses admin dan user menggunakan sistem login.

---

## 🧰 Teknologi yang Digunakan

- **Framework:** CodeIgniter 4  
- **Database:** MySQL  
- **Frontend:** Bootstrap 5, DataTables, jQuery, AJAX  
- **Server:** PHP 8.x  
- **Version Control:** Git & GitHub  

---

## ⚙️ Cara Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/username/nama-repo.git
   cd nama-repo

cp env .env

database.default.hostname = localhost
database.default.database = db_perumahan
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi

php spark migrate

php spark serve

app/
 ├── Controllers/
 ├── Models/
 ├── Views/
 ├── Config/
public/
writable/
.env
composer.json


👨‍💻 Pengembang

Nama: Tegar Setio Nugroho
Peran: Backend Developer
Framework: CodeIgniter 4
Institusi: Politeknik Negeri Banyuwangi

📝 Lisensi

Proyek ini dibuat untuk tujuan pembelajaran dan pengembangan sistem informasi internal.
Silakan gunakan dan modifikasi dengan tetap mencantumkan kredit pengembang.
