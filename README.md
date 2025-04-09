# 🚀 Laravel Docker Loyihasi

Bu loyiha Laravel 11+ versiyasida yozilgan bo‘lib, Docker yordamida konteynerda ishga tushadi.

---
## Kod clone qilingandan keyin  tegishli ruxsatlar berilishi kerak

### Storage permission

```bash
chmod -R 755 storage bootstrap/cache && chown -R www-data:www-data .
```

##  Boshlang‘ich sozlash

### 1. `.env` faylini yarating

```bash
cp .env.example .env
```

### 2.Docker image’ni build qiling

```bash
docker build -t laravel-app .
```

### 3.Konteynerni ishga tushiring

```bash
docker-compose up -d --build
```
##   Laravel sozlamalari

### 1.Composer kutubxonalarini o‘rnating

```bash
docker exec -it laravel-app composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-req=ext-gd
```

### 2.APP_KEY yarating

```bash
docker exec -it laravel-app  php artisan key:generate
```
 
### 3.Ma’lumotlar bazasiga migratsiya qiling

```bash
docker exec -it laravel-app  php artisan migrate
```

### 4.Default malumotlarni insert qiling

```bash
docker exec -it laravel-app  php artisan db:seed
```



