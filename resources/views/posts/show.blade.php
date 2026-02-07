@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('posts.index') }}" class="btn-cute-secondary">
            <i class="bi bi-arrow-left me-2"></i>Tüm Yazılara Dön
        </a>
    </div>

    <!-- Post Content -->
    <div class="cute-card mb-4">
        <!-- Header -->
        <div class="cute-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2 fw-bold">{{ $post->title }}</h1>
                    <div class="d-flex align-items-center">
                        <span class="cute-badge me-2">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $post->created_at->format('d.m.Y') }}
                        </span>
                        <span class="cute-badge">
                            <i class="bi bi-clock me-1"></i>
                            {{ $post->created_at->format('H:i') }}
                        </span>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="d-flex gap-2" onclick="event.stopPropagation()">
                    <a href="{{ route('posts.edit', $post) }}" 
                       class="btn btn-sm btn-cute-secondary">
                        <i class="bi bi-pencil me-1"></i>Düzenle
                    </a>
                    @if($post->image)
                        <form action="{{ route('posts.delete-image', $post) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-sm btn-cute-danger"
                                    onclick="return confirm('Sadece resmi silmek istediğinize emin misiniz? Yazı silinmeyecek.')">
                                <i class="bi bi-trash me-1"></i>Resmi Sil
                            </button>
                        </form>
                    @endif
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
        </div>
        
        <!-- Body -->
        <div class="cute-card-body">
            <!-- Image -->
            @if($post->image)
                <div class="text-center mb-5">
                    <div class="cute-img-frame mx-auto" style="max-width: 600px;">
                        <img src="{{ asset('storage/' . $post->image) }}" 
                             alt="{{ $post->title }}" 
                             class="img-fluid rounded">
                    </div>
                    <p class="text-muted small mt-2">
                        <i class="bi bi-image me-1"></i>{{ basename($post->image) }}
                    </p>
                </div>
            @endif
            
            <!-- Content -->
            <div class="mb-5">
                <p style="font-size: 1.1rem; line-height: 1.8; color: var(--text-dark);">
                    {!! nl2br(e($post->content)) !!}
                </p>
            </div>
            
            <!-- Meta Info -->
            <div class="border-top pt-4 mt-4" style="border-color: rgba(157, 123, 255, 0.1) !important;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary-light) 0%, var(--pastel-blue) 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-calendar-plus" style="color: var(--primary-dark); font-size: 1.5rem;"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-1" style="color: var(--text-light);">Oluşturulma</h6>
                                <p class="mb-0 fw-semibold">{{ $post->created_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3 mt-md-0">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #ffd4ff 0%, #ffe8ff 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-arrow-clockwise" style="color: #ff6bcb; font-size: 1.5rem;"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-1" style="color: var(--text-light);">Son Güncelleme</h6>
                                <p class="mb-0 fw-semibold">{{ $post->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Navigation Buttons -->
    <div class="d-flex justify-content-between">
        <div>
            @if($previous)
                <a href="{{ route('posts.show', $previous) }}" class="btn-cute-secondary">
                    <i class="bi bi-chevron-left me-2"></i>Önceki Yazı
                </a>
            @endif
        </div>

        <div>
            <a href="{{ route('posts.index') }}" class="btn-cute-secondary">
                <i class="bi bi-list-ul me-2"></i>Tüm Yazılar
            </a>
        </div>

        <div>
            @if($next)
                <a href="{{ route('posts.show', $next) }}" class="btn-cute-secondary">
                    Sonraki Yazı<i class="bi bi-chevron-right ms-2"></i>
                </a>
            @endif
        </div>
    </div>
@endsection
