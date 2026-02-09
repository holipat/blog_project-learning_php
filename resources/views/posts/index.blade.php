@extends('layouts.app')

@section('title', 'Blog Yazıları')

@section('content')
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-3" style="color: var(--rose-blush);">
            <i class="bi bi-chat-square-text-fill me-2"></i>Blog Yazıları
        </h1>
        <p class="lead text-muted mb-4">
            Keşfetmeye hazır olduğunuz tüm yazılar burada! ✨
        </p>
        
        <a href="{{ route('posts.create') }}" class="btn btn-silver">
            <i class="bi bi-plus-circle me-2"></i>Yeni Yazı Oluştur
        </a>
    </div>

    <!-- Blog List -->
    @if($posts->isEmpty())
        <!-- Empty State -->
        <div class="cute-card text-center py-5">
            <div class="empty-state">
                <i class="bi bi-journal-text empty-state-icon"></i>
                <h3 class="h4 mb-3" style="color: var(--text-light);">Henüz yazı bulunmuyor</h3>
                <p class="mb-4">İlk blog yazınızı oluşturarak başlayın!</p>
                <a href="{{ route('posts.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>İlk Yazınızı Oluşturun
                </a>
            </div>
        </div>
    @else
        <!-- Blog Posts -->
        @foreach($posts as $post)
            <div class="cute-list-item" style="cursor: pointer;" onclick="window.location='{{ route('posts.show', $post) }}'">
                @if($post->image)
                    <div class="row g-3">
                        <!-- Image Column -->
                        <div class="col-md-3">
                            <div class="cute-img-frame" style="height: 150px;">
                                <img src="{{ asset('storage/' . $post->image) }}" 
                                     alt="{{ $post->title }}" 
                                     class="img-fluid rounded">
                            </div>
                        </div>
                        
                        <!-- Content Column -->
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                                <div style="flex: 1; min-width: 250px;">
                                    <h5 class="mb-2 fw-bold" style="color: var(--primary-dark);">
                                        {{ $post->title }}
                                    </h5>
                                    
                                    <div class="mb-2">
                                        <span class="cute-badge me-2">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $post->created_at->diffForHumans() }}
                                        </span>
                                        <span class="cute-badge">
                                            <i class="bi bi-image me-1"></i>Resimli
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="d-flex gap-2" onclick="event.stopPropagation()">
                                    <a href="{{ route('posts.edit', $post) }}" 
                                       class="btn btn-sm btn-cute-secondary">
                                        <i class="bi bi-pencil me-1"></i>Düzenle
                                    </a>
                                    <form action="{{ route('posts.destroy', $post) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-cute-danger"
                                                onclick="return confirm('Bu yazıyı silmek istediğinize emin misiniz?')">
                                            <i class="bi bi-trash me-1"></i>Sil
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Content Preview -->
                            <p class="mb-2 text-muted">
                                {{ Str::limit($post->content, 200) }}
                            </p>
                            
                            <!-- Read More -->
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i>
                                {{ $post->created_at->format('d.m.Y H:i') }}
                            </small>
                        </div>
                    </div>
                @else
                    <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                        <div style="flex: 1; min-width: 250px;">
                            <h5 class="mb-2 fw-bold" style="color: var(--primary-dark);">
                                {{ $post->title }}
                            </h5>
                            
                            <div class="mb-3">
                                <span class="cute-badge">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $post->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-flex gap-2" onclick="event.stopPropagation()">
                            <a href="{{ route('posts.edit', $post) }}" 
                               class="btn btn-sm btn-cute-secondary">
                                <i class="bi bi-pencil me-1"></i>Düzenle
                            </a>
                            <form action="{{ route('posts.destroy', $post) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-cute-danger"
                                        onclick="return confirm('Bu yazıyı silmek istediğinize emin misiniz?')">
                                    <i class="bi bi-trash me-1"></i>Sil
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Content Preview -->
                    <p class="mb-2 text-muted">
                        {{ Str::limit($post->content, 200) }}
                    </p>
                    
                    <!-- Read More -->
                    <small class="text-muted">
                        <i class="bi bi-clock me-1"></i>
                        {{ $post->created_at->format('d.m.Y H:i') }}
                    </small>
                @endif
            </div>
        @endforeach
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $posts->links() }}
        </div>
        
        <!-- Total Count -->
        <div class="mt-4 text-center">
            <div class="cute-badge d-inline-block px-4 py-2">
                <i class="bi bi-journals me-2"></i>
                Toplam {{ $posts->total() }} yazı
            </div>
        </div>
    @endif
@endsection
