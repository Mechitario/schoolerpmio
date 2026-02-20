# Shri Memorial Public School Admin (Laravel)

School admin dashboard: students, staff, fees, academics. PHP 8.2+, Composer.

## Setup

```bash
cd laravel-admin
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install
npm run build
php artisan serve
```

Open http://127.0.0.1:8000

**CSS:** Tailwind is built locally (no CDN). After changing Blade views or adding Tailwind classes, run `npm run build`. Use `npm run dev` to watch and rebuild on file changes.

**Admin login:** After seeding, sign in at `/admin/login` with **admin@school.com** / **password**. Change the password after first login in production.

**Database:** Default `.env` uses SQLite (no server). For PostgreSQL set `DB_CONNECTION=pgsql` and DB_* in `.env`.

## Routes

| URL | Page |
|-----|------|
| `/` | Landing |
| `/admin/login` | Admin login (email + password) |
| `/admin/dashboard` | Dashboard (auth required) |
| `/admin/students` | Students |
| `/admin/staff` | Staff |
| `/admin/fees` | Fees |
| `/admin/academics` | Exam results |
