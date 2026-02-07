# 👨‍💻 Developer Guide - Blog Projesi

Bu guide, projeyi geliştirirken izlemeniz gereken best practices'leri açıklamaktadır.

## 📚 Proje Yapısı

```
blog_project/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── PostController.php
│   │   └── Requests/
│   ├── Models/
│   │   ├── Post.php        (Soft Delete, User ilişkisi)
│   │   └── User.php        (HasMany ilişkisi)
│   ├── Policies/
│   │   └── PostPolicy.php  (Authorization)
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/
│   │   └── 2026_02_07_100000_add_user_id_to_posts_table.php
│   └── factories/
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       └── posts/
│           ├── index.blade.php
│           ├── show.blade.php
│           ├── create.blade.php
│           └── edit.blade.php
├── routes/
│   └── web.php
├── storage/
│   ├── app/
│   │   └── public/posts/  (Resimler burada)
│   └── logs/
└── public/
    └── storage -> ../storage/app/public (Symbolic Link)
```

## 🔄 Yaygın İşlemler

### Yeni Post Oluşturma (Kod Seviyesinde)

```php
use App\Models\Post;

// Kimlik doğrulama gerekli
$post = Post::create([
    'user_id' => auth()->id(),
    'title' => 'Başlık',
    'content' => 'İçerik',
    'image' => null, // Resim path'i
]);
```

### Post Güncellemesi

```php
$post->update([
    'title' => 'Yeni Başlık',
    'content' => 'Yeni İçerik'
]);
```

### Post Silme (Soft Delete)

```php
// Soft delete
$post->delete();

// Geri yükle
$post->restore();

// Tamamen sil
$post->forceDelete();

// Silinmiş yazıları listele
Post::onlyTrashed()->get();
```

### Resim İşlemleri

```php
use Illuminate\Support\Facades\Storage;

// Resim yükle
$path = $file->storeAs('posts', 'filename.jpg', 'public');

// Resim sil
Storage::disk('public')->delete('posts/filename.jpg');

// Resmi göster
<img src="{{ asset('storage/' . $post->image) }}" />
```

## 🎯 Authorization Pattern

### Controller'da

```php
public function update(Request $request, Post $post)
{
    // Otomatik kontrol
    $this->authorize('update', $post);
    // ...
}
```

### View'de

```blade
@can('update', $post)
    <a href="{{ route('posts.edit', $post) }}">Düzenle</a>
@endcan

@auth
    @if (auth()->user()->id === $post->user_id)
        <button>Sil</button>
    @endif
@endauth
```

## 📦 Eager Loading (N+1 Optimization)

### ❌ Kötü (N+1 Sorgusu)
```php
$posts = Post::all();
foreach ($posts as $post) {
    echo $post->user->name; // Her döngüde 1 sorgu!
}
// 1 + n sorgu = 1 + 10 = 11 sorgu
```

### ✅ İyi (Eager Loading)
```php
$posts = Post::with('user')->get();
foreach ($posts as $post) {
    echo $post->user->name; // Cache'den gelir
}
// 2 sorgu = 1 + 1
```

## 🗄️ Pagination

### Controller
```php
$posts = Post::with('user')->latest()->paginate(10);
return view('posts.index', compact('posts'));
```

### View
```blade
<!-- Yazılar listesi -->
@foreach ($posts as $post)
    <!-- ... -->
@endforeach

<!-- Pagination Links -->
{{ $posts->links() }}

<!-- Sayfa Bilgisi -->
Sayfa {{ $posts->currentPage() }} / {{ $posts->lastPage() }}
Toplam: {{ $posts->total() }}
```

## 🔐 Güvenlik Best Practices

### 1. Validation
```php
$validated = $request->validate([
    'title' => ['required', 'string', 'min:3', 'max:255'],
    'content' => ['required', 'string', 'min:10'],
    'image' => ['nullable', 'image', 'max:2048'],
]);
```

### 2. Authorization
```php
// Policy'den
$this->authorize('update', $post);

// View'de
@can('update', $post)
```

### 3. Dosya Güvenliği
```php
// ✅ Doğru: Storage facade
$path = $file->store('posts', 'public');

// ❌ Yanlış: Public path doğrudan
$file->move(public_path('images'), $name);
```

## 📊 Database Schema

### posts tablosu
```sql
CREATE TABLE posts (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    image VARCHAR(255) NULLABLE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## 🐛 Debugging Tüyoları

### Query Logging
```php
// Controller'da
use Illuminate\Support\Facades\DB;

DB::enableQueryLog();
$posts = Post::all();
dd(DB::getQueryLog());
```

### Model Debugging
```php
$post = Post::find(1);
dd($post->toArray());  // Array olarak göster
dd($post->toJson());   // JSON olarak göster
```

### Exception Handling
```php
try {
    $post = Post::findOrFail($id);
} catch (ModelNotFoundException $e) {
    return redirect()->route('posts.index')->with('error', 'Yazı bulunamadı');
}
```

## 🛠️ Useful Artisan Commands

```bash
# Migration
php artisan migrate              # Çalıştır
php artisan migrate:rollback      # Geri al
php artisan migrate:refresh       # Yeniden oluştur
php artisan migrate:reset         # Sıfırla

# Cache
php artisan cache:clear
php artisan config:cache

# Database
php artisan tinker               # Laravel REPL
php artisan db:seed              # Seed'leri çalıştır
php artisan storage:link         # Storage link oluştur

# Make Commands
php artisan make:model Post       # Model oluştur
php artisan make:controller PostController  # Controller oluştur
php artisan make:policy PostPolicy # Policy oluştur
php artisan make:migration create_posts_table # Migration oluştur
```

## 📝 Logging

```php
use Illuminate\Support\Facades\Log;

Log::info('Bilgi mesajı', ['post_id' => 1]);
Log::warning('Uyarı mesajı');
Log::error('Hata mesajı');
Log::debug('Debug mesajı');

// Dosya: storage/logs/laravel.log
```

## 🧪 Testing (İleride)

```php
// tests/Feature/PostTest.php
public function test_user_can_create_post()
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->post('/posts', [
            'title' => 'Test',
            'content' => 'Test content here',
        ]);
    
    $this->assertDatabaseHas('posts', [
        'user_id' => $user->id,
        'title' => 'Test',
    ]);
}
```

## 💡 Performance Tips

1. **Eager Loading Kullan**
   ```php
   Post::with('user')->get();
   ```

2. **Select Sütunları Sınırla**
   ```php
   Post::select('id', 'title', 'user_id')->get();
   ```

3. **Index Kullan** (Database'de)
   ```php
   $table->index('user_id');
   $table->fullText(['title', 'content']);
   ```

4. **Pagination Kullan**
   ```php
   Post::paginate(15);
   ```

5. **Caching Kullan**
   ```php
   Cache::remember('posts', 60, function () {
       return Post::all();
   });
   ```

## 📞 Sorular & Sorunlar

### Resimler gösterilmiyor?
```bash
php artisan storage:link
```

### Migration hatasının çözülüyor?
```bash
php artisan migrate:rollback
php artisan migrate
```

### Cache sorunları?
```bash
php artisan cache:clear
php artisan config:clear
```

---

**Son Güncelleme**: 7 Şubat 2026
