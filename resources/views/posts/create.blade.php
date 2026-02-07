@extends('layouts.app')

@section('title', 'Yeni Blog Yazısı')

@section('content')
    <h1 class="mb-4">Yeni Blog Yazısı Ekle</h1>
    
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="title" class="form-label">Başlık</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                   id="title" name="title" value="{{ old('title') }}">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="content" class="form-label">İçerik</label>
            <textarea class="form-control @error('content') is-invalid @enderror" 
                      id="content" name="content" rows="5">{{ old('content') }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Resim</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                   id="image" name="image" accept="image/*">
            <div class="form-text">
                İzin verilen formatlar: JPEG, PNG, JPG, GIF. Maksimum 2MB.
            </div>
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Kaydet</button>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">İptal</a>
        </div>
    </form>
@endsection