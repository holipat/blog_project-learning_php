@extends('layouts.app')

@section('title', 'Blog Yazıları')

@section('content')
    <h1 class="mb-4">Blog Yazıları</h1>
    
    @if($posts->isEmpty())
        <div class="alert alert-info">
            Henüz blog yazısı bulunmuyor. İlk yazıyı ekleyin!
        </div>
    @else
        <div class="list-group">
            @foreach($posts as $post)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <!-- RESİM (varsa) -->
                        @if($post->image)
                            <div class="me-3 d-flex align-items-center justify-content-center" style="width: 120px; flex-shrink: 0;">
                                <img src="{{ asset($post->image) }}" 
                                    alt="{{ $post->title }}" 
                                    class="img-fluid rounded"
                                    style="max-height: 80px; height: 100%; object-fit: cover;">
                            </div>
                        @endif
                        <div>
                            <h5>{{ $post->title }}</h5>
                            <p class="mb-1">
                                {{ Str::limit($post->content, 100) }}
                            </p>
                            <small class="text-muted">
                                {{ $post->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('posts.show', $post) }}" 
                               class="btn btn-sm btn-outline-primary">Görüntüle</a>
                            <a href="{{ route('posts.edit', $post) }}" 
                               class="btn btn-sm btn-outline-secondary">Düzenle</a>
                            <form action="{{ route('posts.destroy', $post) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Silmek istediğinize emin misiniz?')">
                                    Sil
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    
    <div class="mt-3">
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            Yeni Blog Yazısı Ekle
        </a>
    </div>
@endsection