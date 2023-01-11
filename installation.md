## Installation Guide

- Download repository
- Extract ke direktori `C:/xampp/htdocs`
- Buka folder di VSCode
- Copy .env.example ke .env
- Ubah Credentials Database
- Jalankan command berikut di terminal VSCode

`php artisan key:generate`
`php artisan migrate:fresh --seed`
`php artisan permission:create-permission-routes`
`php artisan storage:link`
`php artisan optimize:clear`
`php artisan serve`

<!-- 
https://codeanddeploy.com/blog/laravel/laravel-8-user-roles-and-permissions-step-by-step-tutorial#kjNAJj9MlMLUcT2n1u7o2VOaO 
-->
