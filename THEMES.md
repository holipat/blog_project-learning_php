# Tema Sistemi Kullanımı

Bu dokümantasyon, blog projesindeki tema sistemi hakkında bilgi vermektedir.

## Mevcut Temalar

Projede 6 farklı tema bulunmaktadır:

1. **Default** - Mor ve Mavi (Pastel)
2. **Ocean** - Okyanus Mavisi ve Teal
3. **Sunset** - Turuncu ve Pembe
4. **Forest** - Yeşil Orman Teması
5. **Midnight** - Koyu Mavi Gece Teması
6. **Cotton Candy** - Açık Pembe ve Lavanta

## Tema Dosyaları

Tema dosyaları `public/css/themes/` klasöründe yer almaktadır:

```
public/css/themes/
├── default.css
├── ocean.css
├── sunset.css
├── forest.css
├── midnight.css
└── cotton-candy.css
```

## Tema Seçme

### Kullanıcı Arayüzü İle

Kullanıcılar navigasyon çubuğundaki **Tema** düğmesine tıklayarak istediği temayı seçebilirler. Seçilen tema otomatik olarak session'da kaydedilir.

### Doğrudan URL ile

```
/theme/{tema-adı}
```

Örnek:
```
/theme/ocean
/theme/sunset
/theme/forest
```

## Tema Yönetimi

### Tema Helper Kullanımı

`ThemeHelper` sınıfı tema yönetimi için kolaylık sağlamaktadır:

```php
use App\Helpers\ThemeHelper;

// Mevcut temayı al
$currentTheme = ThemeHelper::getCurrentTheme();

// Tüm temaları al
$themes = ThemeHelper::getAvailableThemes();

// Temayı kontrol et
if (ThemeHelper::isThemeActive('ocean')) {
    // Ocean teması aktif
}

// Tema adını al
$themeName = ThemeHelper::getThemeName('ocean'); // "Ocean"
```

### Blade Şablonlarında Kullanımı

Layout dosyasında dinamik olarak tema CSS dosyası yüklenmektedir:

```blade
@php
    $theme = session('theme', 'default');
@endphp
<link href="{{ asset('css/themes/' . $theme . '.css') }}" rel="stylesheet" id="theme-css">
```

## CSS Değişkenleri

Her tema aşağıdaki CSS değişkenlerini tanımlı olarak içerir:

```css
:root {
    --primary-light: /* Açık renk */
    --primary: /* Ana renk */
    --primary-dark: /* Koyu renk */
    --secondary: /* İkincil renk */
    --accent: /* Vurgu renk */
    --pastel-blue: /* Pastel Mavi */
    --pastel-purple: /* Pastel Mor */
    --text-dark: /* Koyu metin */
    --text-light: /* Açık metin */
    --bg-light: /* Arka plan rengi */
    --card-bg: /* Kart arka planı */
    --shadow-soft: /* Yumuşak gölge */
    --shadow-hover: /* Hover gölgesi */
    --radius-sm: /* Küçük border radius */
    --radius-md: /* Orta border radius */
    --radius-lg: /* Büyük border radius */
    --theme-name: /* Tema adı */
}
```

## Yeni Tema Oluşturma

Yeni bir tema oluşturmak için:

### 1. Tema CSS Dosyası

`public/css/themes/` klasöründe yeni bir CSS dosyası oluşturun:

```css
/* My Theme */
:root {
    --primary-light: #...;
    --primary: #...;
    --primary-dark: #...;
    --secondary: #...;
    --accent: #...;
    --pastel-blue: #...;
    --pastel-purple: #...;
    --text-dark: #...;
    --text-light: #...;
    --bg-light: #...;
    --card-bg: #...;
    --shadow-soft: 0 8px 25px rgba(...);
    --shadow-hover: 0 12px 30px rgba(...);
    --radius-sm: 12px;
    --radius-md: 18px;
    --radius-lg: 24px;
    --theme-name: 'My Theme';
}

body {
    background: linear-gradient(135deg, #... 0%, #... 100%);
}
```

### 2. Tema Controller'a Ekleme

`app/Http/Controllers/ThemeController.php` dosyasında `getAvailableThemes()` metoduna yeni temayı ekleyin:

```php
['id' => 'my-theme', 'name' => 'My Theme', 'colors' => '#..., #...'],
```

### 3. Validasyona Ekleme

`ThemeController.php` dosyasında `toggle()` metodunun `$availableThemes` dizisine yeni tema ID'sini ekleyin:

```php
$availableThemes = [
    'default',
    'ocean',
    'sunset',
    'forest',
    'midnight',
    'cotton-candy',
    'my-theme' // Yeni tema
];
```

## Veritabanı Entegrasyonu (İsteğe Bağlı)

Kullanıcı tercihlerini veritabanında saklamak istiyorsanız:

### 1. Migration Oluşturun

```bash
php artisan make:migration add_theme_preference_to_users_table
```

### 2. Migration Dosyasını Düzenleyin

```php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('theme_preference')->default('default');
    });
}
```

### 3. User Model'i Güncelleyin

```php
protected $fillable = ['name', 'email', 'password', 'theme_preference'];
```

### 4. ThemeController'ı Güncelleyin

```php
if (auth()->check()) {
    auth()->user()->update(['theme_preference' => $theme]);
}
```

## Middleware Oluşturma (İsteğe Bağlı)

Sayfa yüklenirken veritabanından tema tercihini yüklemek için middleware oluşturun:

```bash
php artisan make:middleware LoadUserTheme
```

Middleware içeriği:

```php
public function handle(Request $request, Closure $next)
{
    if (auth()->check() && auth()->user()->theme_preference) {
        session(['theme' => auth()->user()->theme_preference]);
    }
    return $next($request);
}
```

## Renk Seçimi

Temalar tasarlanırken dikkate alınan renk paletleri:

- **Default**: Pastel Mor ve Mavi
- **Ocean**: Deniz Mavisi Temaları
- **Sunset**: Gündoğumu Renkleri
- **Forest**: Doğal Yeşil Tonları
- **Midnight**: Koyu Mavi Gece Teması
- **Cotton Candy**: Şeker Pembe

## Sorun Giderme

### Tema CSS yüklenmiyorsa

1. `public/css/themes/` klasöründe CSS dosyalarının var olduğunu kontrol edin
2. Layout dosyasını sayfayı yenileyerek kontrol edin
3. Tarayıcı önbelleğini temizleyin

### Eski tema görüntüleniyorsa

1. Session'ı temizleyin
2. Tarayıcı çerezlerini silin
3. Incognito/Private pencere açarak test edin

## İlişkili Dosyalar

- `resources/views/layouts/app.blade.php` - Ana layout
- `app/Http/Controllers/ThemeController.php` - Tema kontrolörü
- `app/Helpers/ThemeHelper.php` - Helper fonksiyonları
- `routes/web.php` - Tema routes
- `public/css/themes/` - Tema dosyaları
