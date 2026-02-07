<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog Sistemi')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 20px; }
        .container { max-width: 800px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('posts.index') }}">Blog Sistemi</a>
                <div class="navbar-nav">
                    <a class="nav-link" href="{{ route('posts.index') }}">Bloglar</a>
                    <a class="nav-link" href="{{ route('posts.create') }}">Yeni Ekle</a>
                </div>
            </div>
        </nav>

        <!-- Flash Mesajları -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- İçerik -->
        <div class="card">
            <div class="card-body">
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-4 text-center text-muted">
            Blog Sistemi &copy; {{ date('Y') }}
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>