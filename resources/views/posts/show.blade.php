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
            @if($post->image)
                <div class="text-center p-3">  <!-- Resmi ortala -->
                    <img src="{{ asset($post->image) }}" 
                        class="img-fluid rounded mx-auto d-block"  
                        alt="{{ $post->title }}"
                        style="max-height: 700px; width: auto;">  <!-- Maksimum yükseklik -->
                </div>
            @endif
            
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