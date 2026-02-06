@extends('layouts.app')

@section('title', 'Düzenle: ' . $post->title)

@section('content')
    <h1 class="mb-4">Blog Yazısını Düzenle</h1>
    
    <form action="{{ route('posts.update', $post) }}" method="POST">
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
        
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Güncelle</button>
            <a href="{{ route('posts.show', $post) }}" class="btn btn-secondary">İptal</a>
        </div>
    </form>
@endsection