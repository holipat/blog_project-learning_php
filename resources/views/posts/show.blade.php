@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <h1>{{ $post->title }}</h1>
        <div class="btn-group">
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
    
    <div class="card">
        <div class="card-body">
            <p class="card-text">{{ $post->content }}</p>
        </div>
        <div class="card-footer text-muted">
            <small>
                Oluşturulma: {{ $post->created_at->format('d.m.Y H:i') }} |
                Son Güncelleme: {{ $post->updated_at->diffForHumans() }}
            </small>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">
            ← Tüm Bloglara Dön
        </a>
    </div>
@endsection