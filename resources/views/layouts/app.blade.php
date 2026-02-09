<!DOCTYPE html>
<html lang="tr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Küçük Blog Dünyası - Bloogy">
    <title>@yield('title', 'Blogy') | Küçük Blog Dünyası</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Dynamic Theme CSS -->
    @php $theme = session('theme', 'default'); @endphp
    <link href="{{ asset('css/themes/' . $theme . '.css') }}" rel="stylesheet" id="theme-css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; font-weight: 600; color: var(--text-dark); }
        
        body { font-family: 'Nunito', sans-serif; color: var(--text-dark); min-height: 100vh; padding-bottom: 60px; }
        
        .navbar-blury { background: rgba(255, 255, 255, 0.9) !important; backdrop-filter: blur(10px); border-bottom: 1px solid rgba(157, 123, 255, 0.1); box-shadow: 0 4px 20px rgba(157, 123, 255, 0.05); }
        
        .navbar-brand { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.8rem; background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        
        .nav-link { color: var(--text-light) !important; font-weight: 500; padding: 8px 16px !important; border-radius: 50px; margin: 0 4px; transition: all 0.3s ease; }
        .nav-link:hover { color: var(--primary) !important; background: rgba(157, 123, 255, 0.08); transform: translateY(-2px); }
        
        .cute-card { background: var(--card-bg); border: none; border-radius: var(--radius-md); box-shadow: var(--shadow-soft); transition: all 0.3s ease; overflow: hidden; }
        .cute-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-hover); }
        .cute-card-header { background: linear-gradient(90deg, var(--primary-light) 0%, var(--pastel-blue) 100%); border-bottom: 1px solid rgba(157, 123, 255, 0.1); padding: 20px 25px; border-radius: var(--radius-md) var(--radius-md) 0 0 !important; }
        .cute-card-body { padding: 25px; }
        
        .btn-cute-primary { background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%); color: white; border: none; border-radius: 50px; padding: 10px 24px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(157, 123, 255, 0.3); }
        .btn-cute-primary:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(157, 123, 255, 0.4); color: white; }
        
        .btn-cute-secondary { background: white; color: var(--primary); border: 2px solid var(--primary-light); border-radius: 50px; padding: 10px 24px; font-weight: 600; transition: all 0.3s ease; }
        .btn-cute-secondary:hover { background: var(--primary-light); color: var(--primary-dark); border-color: var(--primary); transform: translateY(-2px); }
        
        .btn-cute-danger { background: linear-gradient(90deg, #ff9d9d 0%, #ffb3b3 100%); color: white; border: none; border-radius: 50px; padding: 8px 20px; font-weight: 600; transition: all 0.3s ease; }
        .btn-cute-danger:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(255, 157, 157, 0.3); color: white; }
        
        .cute-list-item { background: white; border: none; border-radius: var(--radius-sm); margin-bottom: 12px; padding: 20px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); transition: all 0.3s ease; border-left: 4px solid var(--primary-light); cursor: pointer; }
        .cute-list-item:hover { transform: translateX(5px); box-shadow: 0 6px 20px rgba(157, 123, 255, 0.1); border-left-color: var(--primary); }
        
        .cute-form-control { border: 2px solid var(--primary-light); border-radius: 12px; padding: 12px 16px; font-size: 16px; transition: all 0.3s ease; background: rgba(255, 255, 255, 0.9); }
        .cute-form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(157, 123, 255, 0.2); background: white; }
        
        .cute-badge { background: linear-gradient(90deg, var(--pastel-blue) 0%, var(--pastel-purple) 100%); color: var(--primary-dark); padding: 6px 14px; border-radius: 50px; font-weight: 600; font-size: 0.85rem; }
        
        .cute-alert { border: none; border-radius: var(--radius-sm); padding: 16px 20px; margin-bottom: 20px; }
        .alert-success { background: linear-gradient(90deg, #d4ffd4 0%, #e8ffe8 100%); color: #2d8a2d; border-left: 4px solid #4CAF50; }
        .alert-info { background: linear-gradient(90deg, #d4f4ff 0%, #e8f8ff 100%); color: #1e88e5; border-left: 4px solid #2196F3; }
        .alert-danger { background: linear-gradient(90deg, #ffd4d4 0%, #ffe8e8 100%); color: #e53935; border-left: 4px solid #F44336; }
        
        .cute-img-frame { border-radius: var(--radius-sm); overflow: hidden; border: 3px solid white; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); }
        .cute-img-frame img { width: 100%; height: 100%; object-fit: cover; }
        
        .cute-footer { background: linear-gradient(90deg, var(--primary-light) 0%, var(--pastel-blue) 100%); border-top: 1px solid rgba(157, 123, 255, 0.1); padding: 25px 0; margin-top: 50px; text-align: center; color: var(--text-light); }
        
        .empty-state { text-align: center; padding: 60px 20px; color: var(--text-light); }
        .empty-state-icon { font-size: 4rem; color: var(--primary-light); margin-bottom: 20px; }
        
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .float-animation { animation: float 3s ease-in-out infinite; }
        
        .theme-switcher-btn { background: none; border: none; padding: 8px 12px; cursor: pointer; font-size: 1.2rem; color: var(--primary); transition: all 0.3s ease; display: flex; align-items: center; gap: 6px; }
        .theme-switcher-btn:hover { transform: scale(1.1) rotate(20deg); color: var(--primary-dark); }
        
        .theme-selector { display: none; position: absolute; top: 100%; right: 0; background: var(--card-bg); border-radius: var(--radius-md); box-shadow: var(--shadow-hover); margin-top: 10px; padding: 12px; min-width: 200px; z-index: 1000; animation: slideDown 0.3s ease; }
        .theme-selector.show { display: block; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        
        .theme-option { padding: 12px 16px; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 12px; text-decoration: none; color: var(--text-dark); font-weight: 500; margin-bottom: 6px; }
        .theme-option:hover { background: rgba(157, 123, 255, 0.1); color: var(--primary); transform: translateX(4px); }
        .theme-option.active { background: linear-gradient(90deg, var(--primary-light) 0%, var(--pastel-blue) 100%); color: var(--primary-dark); font-weight: 600; }
        
        @media (max-width: 768px) { .cute-card-body { padding: 20px; } .navbar-brand { font-size: 1.5rem; } }
    </style>
</head>
<body class="d-flex flex-column h-100">
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-blury py-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('posts.index') }}"><i class="bi bi-chat-square-heart-fill me-2"></i>Bloogy</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('posts.index') }}"><i class="bi bi-house-door me-1"></i> Ana Sayfa</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('posts.create') }}"><i class="bi bi-plus-circle me-1"></i> Yeni Yazı</a></li>
                    <li class="nav-item position-relative">
                        <button class="theme-switcher-btn" id="themeSwitcherBtn" title="Tema Değiştir"><i class="bi bi-palette-fill"></i><span class="d-none d-lg-inline small">Tema</span></button>
                        <div class="theme-selector" id="themeSelector">
@php
$themeNames = [
    'default' => 'Default',
    'cutie' => 'Cutie',
    'ocean' => 'Ocean',
    'sunset' => 'Sunset',
    'forest' => 'Forest',
    'midnight' => 'Midnight',
    'cotton-candy' => 'Cotton Candy',
    'wizard-grimoire' => 'Wizard Grimoire',
    'dark-fantasy-romance' => 'Dark Fantasy Romance'
];
$themes = [];
foreach ($themeNames as $id => $name) {
    $themes[] = ['id' => $id, 'name' => $name];
}
$currentTheme = session('theme', 'default');
@endphp
                            @foreach($themes as $t)<a href="{{ route('theme.toggle', $t['id']) }}" class="theme-option {{ $currentTheme === $t['id'] ? 'active' : '' }}"><i class="bi bi-check-lg" style="visibility: {{ $currentTheme === $t['id'] ? 'visible' : 'hidden' }}; width: 16px;"></i>{{ $t['name'] }}</a>@endforeach
                        </div>
                    </li>
                </ul>
            </div>
    </nav>
    
    <!-- Main Content -->
    <main class="container my-5 flex-grow-1">
        <div class="row justify-content-center">
            <!-- Alerts displayed at full width above content -->
            @if(session('success'))<div class="col-12"><div class="cute-alert alert-success fade show"><div class="d-flex align-items-center"><i class="bi bi-check-circle-fill me-3" style="font-size: 1.5rem;"></i><div>{{ session('success') }}</div></div></div></div>@endif
            @if(session('error'))<div class="col-12"><div class="cute-alert alert-danger fade show"><div class="d-flex align-items-center"><i class="bi bi-exclamation-triangle-fill me-3" style="font-size: 1.5rem;"></i><div>{{ session('error') }}</div></div></div></div>@endif
            <div class="col-lg-10 col-xl-8">
                @yield('content')
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="cute-footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-md-start mb-3 mb-md-0">
                    <h5 class="mb-2"><i class="bi bi-chat-square-heart-fill me-2"></i>Bloogy</h5>
                    <p class="mb-0 small">Küçük blog dünyasına hoş geldiniz</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="small">© {{ date('Y') }} - Tüm hakları saklıdır.<span class="ms-2">Laravel</span></div>
            </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
    (function() {
        'use strict';
        
        // Single DOMContentLoaded handler for better INP
        document.addEventListener('DOMContentLoaded', function() {
            
            // Theme switcher
            var themeSwitcherBtn = document.getElementById('themeSwitcherBtn');
            var themeSelector = document.getElementById('themeSelector');
            if (themeSwitcherBtn && themeSelector) {
                themeSwitcherBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    themeSelector.classList.toggle('show');
                });
            }
            
            // Close theme selector on click outside
            document.addEventListener('click', function(e) {
                if (themeSelector && !themeSelector.contains(e.target) && 
                    !e.target.closest('.theme-switcher-btn')) {
                    themeSelector.classList.remove('show');
                }
            });
            
            // Close on theme option click
            var themeOptions = document.querySelectorAll('.theme-option');
            themeOptions.forEach(function(option) {
                option.addEventListener('click', function() {
                    if (themeSelector) themeSelector.classList.remove('show');
                });
            });
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    if (typeof bootstrap !== 'undefined') {
                        new bootstrap.Alert(alert).close();
                    }
                });
            }, 5000);
            
            // Character counter for content textarea
            var contentTextarea = document.getElementById('content');
            if (contentTextarea) {
                var counter = document.createElement('div');
                counter.className = 'text-end text-muted small mt-2';
                counter.innerHTML = '<i class="bi bi-text-left me-1"></i><span id="charCount">0</span> karakter';
                contentTextarea.parentNode.appendChild(counter);
                
                var charCount = document.getElementById('charCount');
                charCount.textContent = contentTextarea.value.length;
                
                contentTextarea.addEventListener('input', function() {
                    charCount.textContent = this.value.length;
                });
            }
            
            // Title character counter
            var titleInput = document.getElementById('title');
            if (titleInput) {
                var titleCounter = document.createElement('div');
                titleCounter.className = 'text-end text-muted small mt-2';
                titleCounter.innerHTML = '<i class="bi bi-type me-1"></i><span id="titleCount">0</span>/100';
                titleInput.parentNode.appendChild(titleCounter);
                
                var titleCount = document.getElementById('titleCount');
                titleCount.textContent = titleInput.value.length;
                
                titleInput.addEventListener('input', function() {
                    var count = this.value.length;
                    titleCount.textContent = count;
                    if (count > 90) titleCount.style.color = 'var(--danger)';
                    else if (count > 70) titleCount.style.color = 'var(--warning)';
                    else titleCount.style.color = '';
                });
            }
        });
    })();
    </script>
    @stack('scripts')
</body>
</html>

