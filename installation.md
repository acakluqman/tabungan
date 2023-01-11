## Installation Guide

- Download repository
- Extract ke direktori `C:/xampp/htdocs`
- Buka folder di VSCode
- Copy `.env.example` ke `.env`
- Ubah credentials database
- Jalankan command berikut di terminal VSCode

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

<!-- 
https://codeanddeploy.com/blog/laravel/laravel-8-user-roles-and-permissions-step-by-step-tutorial#kjNAJj9MlMLUcT2n1u7o2VOaO 
-->
