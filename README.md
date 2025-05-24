Sistem Manajemen Tugas
API sederhana untuk mengelola pengguna dan tugas dengan kontrol akses berbasis peran.

Cara Memulai
Ambil kode: git clone <repo-url>
Pasang dependensi: composer install
Salin .env.example jadi .env dan atur pengaturan database.
Jalankan migrasi: php artisan migrate
Nyalakan server: php artisan serve
Buka frontend di http://localhost:8000/frontend/index.html
Pakai Docker
Pasang Docker dan Docker Compose.
Jalankan: docker-compose up -d
Akses di http://localhost:8000
Uji Coba
Jalankan: php artisan test --coverage

Jadwal Otomatis
Jalankan: php artisan schedule:run atau tambahkan ke cron: * * * * * php /path/to/artisan schedule:run

Dokumentasi API
Cek Swagger di: http://localhost:8000/api/documentation
