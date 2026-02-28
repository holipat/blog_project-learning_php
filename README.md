# 📝 Blog Projesi

Zarif ve modern bir blog uygulaması. **Laravel 12** ile yapılmıştır.

## 🎨 Özellikler

✨ **Modern Tasarım**
- Pastel renkler ve yumuşak gölgeler
- Responsive Bootstrap 5 tasarımı
- Smooth animasyonlar ve geçişler

📝 **Blog Yönetimi**
- Blog yazıları oluştur, oku, güncelle, sil
- Resim yükleme ve yönetimi
- Yazıdan önceki/sonraki yazılara gezinme
- Pagination ile yazı listesi

🔐 **Güvenlik**
- Kullanıcı doğrulama (Authentication)
- Yetkilendirme kontrolü (Authorization/Policies)
- Secure dosya yönetimi
- CSRF koruması

⚡ **Performans**
- N+1 sorgu optimizasyonu
- Soft delete ile veri kurtarma
- Pagination ile sayfa yönetimi

## 🚀 Hızlı Başlangıç

### Gereksinimler

- PHP 8.2+
- Composer
- MySQL/MariaDB

### Kurulum

1. **Projeyi klonla.**
   ```bash
   cd blog_project-learning_php
   ```

2. **Bağımlılıkları yükle**
   ```bash
   composer install
   ```

3. **Environment dosyasını konfigure et**
   ```bash
   cp .env.example .env
   ```

4. **Uygulama keyi oluştur**
   ```bash
   php artisan key:generate
   ```

5. **Veritabanını konfigure et** (.env dosyasında)
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=blog_project
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Setup script'ini çalıştır**
   
   **Windows için:**
   ```bash
   setup.bat
   ```
   
   **Linux/Mac için:**
   ```bash
   bash setup.sh
   ```
   
   Veya manuel olarak:
   ```bash
   php artisan migrate
   php artisan storage:link
   php artisan config:cache
   ```

7. **Projeyi başlat**
   ```bash
   php artisan serve
   ```
   
   Ardından: http://localhost:8000 adresine gidin.

## 📚 Dokümantasyon

### Yeni Başlayanlar
- [IMPROVEMENTS.md](./IMPROVEMENTS.md) - Yapılan tüm iyileştirmeler
- [DEVELOPER_GUIDE.md](./DEVELOPER_GUIDE.md) - Developer rehberi

### Proje Yapısı
```
blog_project/
├── app/
│   ├── Http/Controllers/PostController.php
│   ├── Models/Post.php
│   ├── Models/User.php
│   └── Policies/PostPolicy.php
├── database/migrations/
├── resources/views/posts/
├── routes/web.php
└── storage/app/public/posts/
```

## 🎯 İyileştirmeleri

### Modeller
- ✅ Eloquent ilişkileri (One-to-Many)
- ✅ Soft delete desteği
- ✅ Type hints ve documentation

### Controller
- ✅ Pagination (10 yazı/sayfa)
- ✅ N+1 optimization (Eager Loading)
- ✅ Secure file handling (Storage facade)
- ✅ Authorization checks

### Güvenlik
- ✅ Authentication middleware
- ✅ Authorization policies
- ✅ Dosyalar storage/public'te (secure)
- ✅ CSRF protection

### Database
- ✅ user_id foreign key
- ✅ Soft delete sütunu
- ✅ Cascade delete/update

## 💻 Kullanım

### Blog Yazısı Oluşturma

1. "Yeni Yazı Oluştur" butonuna tıkla
2. Başlık, içerik ve (isteğe bağlı) resim gir
3. "Oluştur" butonuna tıkla

### Blog Yazısını Düzenleme

1. Yazıda "Düzenle" butonuna tıkla
2. Başlık ve içeriği değiştir
3. "Güncelle" butonuna tıkla

### Blog Yazısını Silme

1. Yazıda "Sil" butonuna tıkla
2. Silmeyi onayla

**Not**: Yalnızca yazının sahibi tarafından silinebilir!

## 🔧 Komut Referansı

```bash
# Veritabanı
php artisan migrate                    # Migration'ları çalıştır
php artisan migrate:rollback           # Son migration'ı geri al
php artisan tinker                     # Laravel REPL

# Cache
php artisan cache:clear                # Cache temizle
php artisan config:cache               # Config cache

# Storage
php artisan storage:link               # Symbolic link oluştur

# Make
php artisan make:model Model           # Model oluştur
php artisan make:controller Controller # Controller oluştur
php artisan make:migration create_table # Migration oluştur
```

## 📊 Database Schema

### posts tablosu
```
id          - BIGINT PRIMARY KEY
user_id     - BIGINT UNSIGNED (FK -> users)
title       - VARCHAR(255)
content     - LONGTEXT
image       - VARCHAR(255) NULLABLE
created_at  - TIMESTAMP
updated_at  - TIMESTAMP
deleted_at  - TIMESTAMP (Soft Delete)
```

## 🔐 Güvenlik Notu

- Resimler `storage/app/public/posts/` dizinine kaydedilir
- `public/storage` symbolic link'i ile erişilir
- Dosyalar random isimlendirme kullanır
- CSRF koruması her POST/PUT/DELETE isteğine

## 🛠️ Troubleshooting

### Resimler gösterilmiyor?
```bash
php artisan storage:link
```

### Cache sorunları?
```bash
php artisan cache:clear
php artisan config:clear
```

### Migration hatası?
```bash
php artisan migrate:rollback
php artisan migrate
```

### Permission hatası?
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

---

**Son Güncelleme**: 28 Şubat 2026  
**Framework**: Laravel 12  
**PHP Sürümü**: 8.2+  
**Database**: MySQL 8.0+  


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
