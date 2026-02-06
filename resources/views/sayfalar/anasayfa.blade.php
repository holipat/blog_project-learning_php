<!DOCTYPE html>
<html>
<head>
    <title>İlk Sayfam</title>
</head>
<body>
    <h1>Merhaba {{ $isim ?? 'Ziyaretçi' }}</h1>
    <p>Bugün: {{ date('d.m.Y') }}</p>
    
    @if(isset($isim))
        <p>Hoş geldin, {{ $isim }}!</p>
    @else
        <p>Lütfen isminizi girin.</p>
    @endif
</body>
</html>