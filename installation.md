## Installation Guide

- Download repository
- Extract ke direktori `C:/xampp/htdocs`
- Buka folder di VSCode
- Copy `.env.example` ke `.env`
- Ubah credentials database (DB_DATABASE, DB_USERNAME dan DB_PASSWORD)
- Jalankan command berikut di terminal VSCode

```bash
composer install
```

```bash
php artisan key:generate
```

```bash
php artisan migrate:fresh --seed
```

```bash
php artisan permission:create-permission-routes
```

```bash
php artisan db:seed --class=PermissionsSeeder
```

```bash
php artisan storage:link
```

```bash
php artisan optimize:clear
```

```bash
php artisan serve
```
