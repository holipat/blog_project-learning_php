@extends('layouts.app')

@section('title', 'Düzenle: ' . $post->title)

@section('content')
    <h1 class="mb-4">Blog Yazısını Düzenle</h1>
    
        <!-- MEVCUT RESMİ GÖSTER (varsa) -->
    @if($post->image)
        <div class="mb-3">
            <p class="form-label">Mevcut Resim:</p>
            <form action="{{ route('posts.delete-image', $post) }}" 
                      method="POST" class="d-inline">
                    
                </form>
            <img src="{{ asset($post->image) }}" 
                 class="img-fluid rounded mx-auto d-block"  
                        alt="{{ $post->title }}"
                        style="max-height: 700px; width: auto;">
            <div class="form-text">
                <a href="{{ asset($post->image) }}" target="_blank">Resmi görüntüle</a>
            </div>
        </div>
    @endif

    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="title" class="form-label">Başlık</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                   id="title" name="title" value="{{ old('title', $post->title) }}">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="content" class="form-label">İçerik</label>
            <textarea class="form-control @error('content') is-invalid @enderror" 
                      id="content" name="content" rows="5">{{ old('content', $post->content) }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3">
            <label for="image" class="form-label">
                @if($post->image)
                    Resmi Değiştir
                @else
                    Resim Ekle
                @endif (Opsiyonel)
            </label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                   id="image" name="image" accept="image/*">
            <div class="form-text">
                Boş bırakırsanız mevcut resim korunur. 
                Maksimum 2MB. İzin verilen formatlar: JPEG, PNG, JPG, GIF.
            </div>
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Güncelle</button>
                                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Resmi silmek istediğinize emin misiniz?')">
                        <i class="bi bi-trash"></i> Resmi Sil
                    </button>
            <a href="{{ route('posts.show', $post) }}" class="btn btn-secondary">İptal</a>
        </div>
    </form>
@endsection