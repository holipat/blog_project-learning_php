@echo off
REM Blog Project Setup Script for Windows
REM Bu script projeyi çalıştırmaya hazırlar

echo.
echo 🎬 Blog Project Setup Başlıyor...
echo.

REM 1. Migration'ları çalıştır
echo 📊 Veritabanı migration'ları çalıştırılıyor...
call php artisan migrate

REM 2. Storage link oluştur
echo.
echo 🔗 Storage symbolic link oluşturuluyor...
call php artisan storage:link

REM 3. Cache temizle
echo.
echo 🧹 Cache temizleniyor...
call php artisan config:cache

echo.
echo ✅ Setup tamamlandı!
echo.
echo 📝 Yapılan işlemler:
echo    1. Veritabanı migration'ları çalıştırıldı
echo    2. Storage symbolic link oluşturuldu
echo    3. Cache temizlendi
echo.
echo 🚀 Proje şimdi çalışmaya hazır!
echo.
echo ℹ️  Projeyi çalıştırmak için:
echo    php artisan serve
echo.
pause
