#!/bin/bash
# Blog Project Setup Script
# Bu script projeyi çalıştırmaya hazırlar

echo "🎬 Blog Project Setup Başlıyor..."
echo ""

# 1. Migration'ları çalıştır
echo "📊 Veritabanı migration'ları çalıştırılıyor..."
php artisan migrate

# 2. Storage link oluştur
echo "🔗 Storage symbolic link oluşturuluyor..."
php artisan storage:link

# 3. Cache temizle
echo "🧹 Cache temizleniyor..."
php artisan config:cache

echo ""
echo "✅ Setup tamamlandı!"
echo ""
echo "📝 Yapılan işlemler:"
echo "   1. Veritabanı migration'ları çalıştırıldı"
echo "   2. Storage symbolic link oluşturuldu"
echo "   3. Cache temizlendi"
echo ""
echo "🚀 Proje şimdi çalışmaya hazır!"
echo ""
echo "ℹ️  Projeyi çalıştırmak için:"
echo "   php artisan serve"
echo ""
