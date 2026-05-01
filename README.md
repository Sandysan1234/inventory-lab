<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
---

## 📦 Inventaris Laboratorium

Proyek ini adalah aplikasi manajemen inventaris laboratorium berbasis Laravel. Anda dapat menggunakannya untuk mencatat, mengelola, dan memantau aset laboratorium seperti ruangan, kategori, barang, dan log perawatan.

---

## 🚀 Cara Menggunakan

1. **Clone repository ini:**
	```bash
	git clone https://github.com/username/intventaris-lab.git
	cd intventaris-lab
	```
2. **Install dependensi PHP dan Node.js:**
	```bash
	composer install
	npm install
	```
3. **Salin file environment dan generate key:**
	```bash
	cp .env.example .env
	php artisan key:generate
	```
4. **Konfigurasi database** di file `.env` sesuai kebutuhan Anda.
5. **Jalankan migrasi database:**
	```bash
	php artisan migrate
	```
6.Jalankan seeder
```bash
php artisan db:seed
```

7. **Jalankan server lokal:**
	```bash
	php artisan serve
	```
7. **Akses aplikasi** di [http://localhost:8000](http://localhost:8000)

---

## 🤝 Kontribusi

Kontribusi sangat terbuka! Berikut langkah-langkah untuk berkontribusi:

1. Fork repository ini.
2. Buat branch fitur/bugfix baru (`git checkout -b fitur-anda`).
3. Commit perubahan Anda (`git commit -m 'Deskripsi perubahan'`).
4. Push ke branch Anda (`git push origin fitur-anda`).
5. Buat Pull Request ke branch `main`.

Pastikan kode Anda mengikuti standar Laravel dan sudah dites sebelum mengajukan PR.

---

## 📄 Lisensi

Proyek ini menggunakan lisensi MIT. Silakan gunakan, modifikasi, dan distribusikan sesuai kebutuhan.

---

## 📬 Kontak & Bantuan

Jika ada pertanyaan, silakan buat [issue](https://github.com/username/intventaris-lab/issues) atau hubungi maintainer.

---

- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
